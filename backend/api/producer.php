<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// RabbitMQ connection
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();

// Declare a queue
$channel->queue_declare('user_requests', false, true, false, false);

// Get data from frontend
$data = json_encode([
    "action" => $_POST['action'],  // login, register, order
    "username" => $_POST['username'] ?? '',
    "password" => $_POST['password'] ?? '',
    "order" => $_POST['order'] ?? []
]);

$msg = new AMQPMessage($data, ['delivery_mode' => 2]);

// Publish message
$channel->basic_publish($msg, '', 'user_requests');

echo " [x] Sent request to RabbitMQ\n";

// Close connection
$channel->close();
$connection->close();
?>
