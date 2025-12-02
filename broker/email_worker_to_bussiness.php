<?php
/**
 * Business Email Worker
 * Handles: contact form + catering form
 * Sends both to business inbox only.
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "-----------------------------------------\n";
echo " Business Email Worker Starting...\n";
echo "-----------------------------------------\n";

$autoload = __DIR__ . '/../../vendor/autoload.php';
require_once $autoload;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// BUSINESS INBOX
$BUSINESS_EMAIL = "cfish@tocfoodmarket.com";

// Connect to RabbitMQ
try {
    $connection = new AMQPStreamConnection(
        '98.82.149.231',
        5672,
        'totc',
        'Totc2025'
    );
    echo "[✓] Connected to RabbitMQ\n";
} catch (Throwable $e) {
    echo "[ERROR] RabbitMQ connection failed:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}

$channel = $connection->channel();
$queueName = 'business_email_queue';  // <- new queue
$channel->queue_declare($queueName, false, true, false, false);

echo "[✓] Listening on queue: {$queueName}\n";


// CALLBACK HANDLER -------------------------------------------------
$callback = function ($msg) use ($BUSINESS_EMAIL) {

    echo "\n-----------------------------------------\n";
    echo "[x] Received message: {$msg->body}\n";

    $data = json_decode($msg->body, true);

    if (!is_array($data) || empty($data['action'])) {
        echo "[!] Invalid message\n";
        return $msg->ack();
    }

    $action = $data['action'];
    $mail = new PHPMailer(true);

    try {
        // SMTP CONFIG
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cfish@tocfoodmarket.com';
        $mail->Password = 'ulttzryzxdzwpqlf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Business email receives everything
        $mail->setFrom('no-reply@tasteofthecaribbeanfoodmarket.com', 'Taste of the Caribbean');
        $mail->addAddress($BUSINESS_EMAIL);

        $mail->isHTML(true);

        // CONTACT FORM
        if ($action === "contact_form") {

            $mail->Subject = "New Contact Message from {$data['name']}";
            $mail->Body = "
                <h3>New Contact Message</h3>
                <strong>Name:</strong> {$data['name']} <br>
                <strong>Email:</strong> {$data['email']} <br><br>
                <strong>Message:</strong><br>
                {$data['message']}<br><br>
            ";

        }

        // CATERING REQUEST
        else if ($action === "catering_request") {

            $mail->Subject = "New Catering Request — {$data['name']}";
            $mail->Body = "
                <h3>Catering Request</h3>
                <strong>Name:</strong> {$data['name']}<br>
                <strong>Email:</strong> {$data['email']}<br>
                <strong>Phone:</strong> {$data['phone']}<br>
                <strong>Event Date:</strong> {$data['event_date']}<br>
                <strong>Guests:</strong> {$data['guests']}<br><br>
                <strong>Message:</strong><br>
                {$data['message']}<br><br>
            ";

        }

        else {
            echo "[!] Unknown action: $action\n";
            return $msg->ack();
        }

        $mail->send();
        echo "[✓] Email sent to business inbox\n";

    } catch (Exception $e) {
        echo "[!] PHPMailer Error: {$mail->ErrorInfo}\n";
    }

    $msg->ack();
};


// RUN WORKER -----------------------------------------------------
$channel->basic_qos(null, 1, null);
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

echo "[*] Worker running. Waiting for messages...\n";

while ($channel->is_consuming()) {
    $channel->wait();
}
