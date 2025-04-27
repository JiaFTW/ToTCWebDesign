<?php
// stripe_webhook.php
require_once __DIR__.'/../../vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_YOUR_SECRET_KEY');

$payload    = @file_get_contents('php://input');
$sig_header= $_SERVER['HTTP_STRIPE_SIGNATURE'];
$endpoint_secret = 'whsec_YOUR_WEBHOOK_SECRET';

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch (\Exception $e) {
    http_response_code(400);
    exit("Webhook Error: {$e->getMessage()}");
}

if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;
    // enqueue to RabbitMQ for the restaurant
    $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
      '98.82.149.231', 5672,'totc','Totc2025'
    );
    $channel = $connection->channel();
    $channel->queue_declare('orders', false, true, false, false);
    $channel->basic_publish(
      new \PhpAmqpLib\Message\AMQPMessage(
        json_encode($session), ['delivery_mode'=>2]
      ),
      '', 'orders'
    );
    $channel->close();
    $connection->close();
}

http_response_code(200);
