<?php
header('Content-Type: application/json');

// Validate required fields
$required = ['name', 'email', 'date', 'message'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
        exit;
    }
}

$name    = trim($_POST['name']);
$email   = trim($_POST['email']);
$date    = trim($_POST['date']);
$message = trim($_POST['message']);

// Build message to send to RabbitMQ
$data = [
    'action' => 'send_catering_request',
    'name'   => $name,
    'email'  => $email,
    'date'   => $date,
    'message'=> $message
];

// AMQP
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try {
    $connection = new AMQPStreamConnection(
        '98.82.149.231',
        5672,
        'totc',
        'Totc2025'
    );
    $channel = $connection->channel();
    $channel->queue_declare('catering_queue', false, true, false, false);

    $msg = new AMQPMessage(json_encode($data), [
        'delivery_mode' => 2
    ]);

    $channel->basic_publish($msg, '', 'catering_queue');
    $channel->close();
    $connection->close();

    echo json_encode(['success' => true, 'message' => 'Catering request sent successfully.']);

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
