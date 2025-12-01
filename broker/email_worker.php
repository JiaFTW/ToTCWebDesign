<?php
/**
 * EMAIL WORKER
 * ---------------------------
 * Listens for messages from RabbitMQ in the "email_queue"
 * and sends password reset codes to users.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

// CONNECT TO RABBITMQ
try {
    $connection = new AMQPStreamConnection(
        '98.82.149.231',   // your RabbitMQ host
        5672,              // port
        'totc',            // username
        'Totc2025'         // password
    );
    $channel = $connection->channel();
} catch (Throwable $e) {
    die("Failed to connect to RabbitMQ: " . $e->getMessage());
}

// DECLARE QUEUE
$channel->queue_declare(
    'email_queue',  // queue name
    false,
    true,
    false,
    false
);

echo " [*] Email worker is running and waiting for messages...\n";


// CALLBACK: HANDLE INCOMING MESSAGES
$callback = function ($msg) {

    echo " [x] Received message: " . $msg->body . "\n";

    $data = json_decode($msg->body, true);

    if (!isset($data['action'])) {
        echo " [!] Unknown message type.\n";
        $msg->ack();
        return;
    }

    /**
     * HANDLE RESET CODE EMAIL
     */
    if ($data['action'] === 'send_reset_code') {

        $email = $data['email'];
        $code  = $data['code'];

        echo " [>] Sending reset code to: {$email}\n";

        // Email content
        $subject = "Your Taste of the Caribbean Password Reset Code";
        $message = "
Hello,

Your password reset code is: {$code}

This code expires in 10 minutes.

If you did not request a password reset, please ignore this email.

- Taste of the Caribbean
";
        $headers = "From: no-reply@tasteofthecaribbeanfoodmarket.com\r\n";

        // SEND EMAIL
        if (mail($email, $subject, $message, $headers)) {
            echo " [+] Email sent to {$email}\n";
        } else {
            echo " [!] Failed to send email to {$email}\n";
        }
    }

    // Acknowledge message
    $msg->ack();
};


// CONSUME MESSAGES
$channel->basic_consume(
    'email_queue',
    '',
    false,
    false,
    false,
    false,
    $callback
);

// KEEP WORKER ALIVE
while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
