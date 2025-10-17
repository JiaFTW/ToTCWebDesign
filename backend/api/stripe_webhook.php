<?php
// backend/api/stripe_webhook.php
require_once __DIR__.'/../../vendor/autoload.php';

use Dotenv\Dotenv;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session as StripeSession;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

Dotenv::createImmutable(__DIR__.'/../../')->load();
Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$payload     = @file_get_contents('php://input');
$sigHeader   = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$endpointKey = $_ENV['STRIPE_WEBHOOK_SECRET'];

try {
    $event = Webhook::constructEvent($payload, $sigHeader, $endpointKey);
} catch (\Throwable $e) {
    http_response_code(400);
    exit("Webhook Error: {$e->getMessage()}");
}

/* ——— Handle successful checkout ——— */
if ($event->type === 'checkout.session.completed') {

    /** @var StripeSession $sess */
    $sess = $event->data->object;

    // Expand line‑items for item details
    $sess = StripeSession::retrieve([
        'id'     => $sess->id,
        'expand' => ['line_items'],
    ]);

    /* Build payload for restaurant */
    $order = [
        'id'    => $sess->id,                           // Stripe session id
        'user'  => $sess->customer_details->email,
        'total' => $sess->amount_total / 100,
        'items' => [],
    ];
    foreach ($sess->line_items->data as $li) {
        $order['items'][] = [
            'name'     => $li->description,
            'quantity' => $li->quantity,
            'price'    => $li->amount_total / 100,
        ];
    }

    /* Push to RabbitMQ */
    $conn = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
    $ch   = $conn->channel();
    $ch->queue_declare('orders', false, true, false, false);

    $ch->basic_publish(
        new AMQPMessage(json_encode($order), ['delivery_mode'=>2]),
        '', 'orders'
    );

    $ch->close();
    $conn->close();
}

http_response_code(200);
