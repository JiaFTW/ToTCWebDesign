<?php
/**
 * Email Worker for Taste of the Caribbean
 * Listens on RabbitMQ and sends Reset Code emails
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "-----------------------------------------\n";
echo " Email Worker Starting...\n";
echo "-----------------------------------------\n";

// Load Composer
$autoload = __DIR__ . '/../../vendor/autoload.php';
if (!file_exists($autoload)) {
    echo "ERROR: vendor/autoload.php not found at: $autoload\n";
    exit(1);
}
require_once $autoload;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    echo "[ERROR] Could not connect to RabbitMQ:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}

$channel = $connection->channel();

// Declare queue
$queueName = 'email_queue';
$channel->queue_declare($queueName, false, true, false, false);

echo "[✓] Listening on queue: {$queueName}\n";


// MAIN CALLBACK ---------------------------------------------------------------
$callback = function ($msg) {
    echo "-----------------------------------------\n";
    echo "[x] Received message: {$msg->body}\n";

    $data = json_decode($msg->body, true);

    if (!is_array($data)) {
        echo "[!] ERROR: Message is not valid JSON.\n";
        $msg->ack();
        return;
    }

    if (($data['action'] ?? '') !== 'send_reset_code') {
        echo "[!] ERROR: Unknown action.\n";
        $msg->ack();
        return;
    }

    $email = $data['email'] ?? null;
    $code  = $data['code'] ?? null;

    if (!$email || !$code) {
        echo "[!] ERROR: Missing email or code.\n";
        $msg->ack();
        return;
    }

    echo "[>] Sending reset code to: {$email}\n";

    // Build email message
    $subject = "Your Taste of the Caribbean Password Reset Code";
    $body = "
        Hello,<br><br>
        Your password reset code is: <strong>{$code}</strong><br><br>
        This code expires in 10 minutes.<br><br>
        If you did not request this, ignore this email.<br><br>
        - Taste of the Caribbean Team
    ";

    // PHPMailer setup
    $mail = new PHPMailer(true);

    try {
        // SMTP SETTINGS (these work on any server that supports authenticated SMTP)


        ///// Come back to this and put real SMTP credentials /////
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';           
        $mail->SMTPAuth = true;
        $mail->Username = 'tastecaribiannoreply@gmail.com';  // Replace with real sending account
        $mail->Password = 'app-password-here';               // Use an app password (important)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // From / To
        $mail->setFrom('no-reply@tasteofthecaribbeanfoodmarket.com', 'Taste of the Caribbean');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        echo "[✓] Email sent successfully to {$email}\n";

    } catch (Exception $e) {
        echo "[!] ERROR: PHPMailer failed: {$mail->ErrorInfo}\n";

        // Save failures in a clean log
        file_put_contents(
            __DIR__ . "/email_worker.log",
            date('c') . " PHPMailer error for {$email}: {$mail->ErrorInfo}\n",
            FILE_APPEND
        );
    }

    $msg->ack();
    echo "[✓] Done processing message.\n";
};


// RUN WORKER ------------------------------------------------------------------
$channel->basic_qos(null, 1, null);
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

echo "[*] Worker is running... Waiting for messages...\n";

while ($channel->is_consuming()) {
    $channel->wait();
}
