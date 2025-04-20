<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$email = $_POST['email'];
$password = $_POST['password'];

$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();
$channel->queue_declare('user_requests', false, true, false, false);

$data = json_encode([
    "action" => "login",
    "username" => $email,
    "password" => $password
]);

$msg = new AMQPMessage($data, ['delivery_mode' => 2]);
$channel->basic_publish($msg, '', 'user_requests');

$channel->close();
$connection->close();

// Simulate successful login until RabbitMQ consumer response is implemented
$_SESSION['username'] = $email;
header("Location: ../../frontend/index.php");
exit;
?>
