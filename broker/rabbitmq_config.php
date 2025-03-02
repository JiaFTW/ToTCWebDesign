<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;

$host = '98.82.149.231';
$port = 5672;
$user = 'totc';
$pass = 'Totc2025';

$connection = new AMQPStreamConnection($host, $port, $user, $pass);
$channel = $connection->channel();

echo "Connected to RabbitMQ!";
?>
