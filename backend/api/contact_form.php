<?php
header('Content-Type: application/json');

// Validate required fields
$required = ['name', 'email', 'message'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
        exit;
    }
}

$name    = trim($_POST['name']);
$email   = trim($_POST['email']);
$message = trim($_POST['message']);

// Build message for RabbitMQ
$data = [
    'action'  => 'send_contact_message',
    'name'    => $name,
    'email'   => $email,
    'message' => $message
];

require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try {
    // Connect to RabbitMQ
    $connection = new AMQPStreamConnection(
        '98.82.149.231',
        5672,
        'totc',
        'Totc2025'
    );

    $channel = $connection->channel();
    $channel->queue_declare('contact_queue', false, true, false, false);

    $msg = new AMQPMessage(json_encode($data), [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]);

    $channel->basic_publish($msg, '', 'contact_queue');

    $channel->close();
    $connection->close();

    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'error'   => 'Server error: ' . $e->getMessage()
    ]);
}
