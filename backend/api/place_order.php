<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// RabbitMQ Connection
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();
$channel->queue_declare('orders', false, true, false, false);

// Get order details
$dish = $_POST['dish'];
$quantity = $_POST['quantity'];

if (!isset($_SESSION['order'])) {
    $_SESSION['order'] = [];
}

$_SESSION['order'][] = ['dish' => $dish, 'quantity' => $quantity];

// Create a RabbitMQ message
$data = json_encode([
    "action" => "order",
    "dish" => $dish,
    "quantity" => $quantity,
    "user" => "testuser"  // it'll be replaced with session username
]);

$msg = new AMQPMessage($data, ['delivery_mode' => 2]);
$channel->basic_publish($msg, '', 'orders');

$channel->close();
$connection->close();

header("Location: /../../frontend/order.php");
exit();
 