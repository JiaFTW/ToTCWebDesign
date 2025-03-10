<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// RabbitMQ Connection
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();
$channel->queue_declare('user_requests', false, true, false, false);

// Get form data
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Create RabbitMQ message
$data = json_encode([
    "action" => "register",
    "username" => $username,
    "password" => $password
]);

$msg = new AMQPMessage($data, ['delivery_mode' => 2]);
$channel->basic_publish($msg, '', 'user_requests');

$channel->close();
$connection->close();

echo "Registration request sent!";
?>
