<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// RabbitMQ Connection
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();
$channel->queue_declare('payments', false, true, false, false);

// Get payment details
$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];

// Create RabbitMQ message
$data = json_encode([
    "action" => "payment",
    "card_number" => $card_number,
    "expiry_date" => $expiry_date,
    "cvv" => $cvv,
    "user" => "testuser"
]);

$msg = new AMQPMessage($data, ['delivery_mode' => 2]);
$channel->basic_publish($msg, '', 'payments');

$channel->close();
$connection->close();

echo "Payment request sent!";
?>
