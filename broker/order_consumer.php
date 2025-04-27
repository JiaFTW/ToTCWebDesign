<?php
// broker/order_consumer.php
require_once __DIR__.'/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
  '98.82.149.231',5672,'totc','Totc2025'
);
$channel = $connection->channel();
$channel->queue_declare('orders', false, true, false, false);

echo " [*] Waiting for orders...\n";
$callback = function($msg){
    $order = json_decode($msg->body, true);
    // TODO: insert into your DB, send kitchen notification, emails...
    file_put_contents(
      '/var/log/order_consumer.log',
      date('[Y-m-d H:i:s] ') . "Received order: " . json_encode($order) . "\n",
      FILE_APPEND
    );
    $msg->ack();
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('orders', '', false, false, false, false, $callback);
while ($channel->is_consuming()) {
    $channel->wait();
}
