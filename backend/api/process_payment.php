<?php
// backend/api/process_payment.php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Verify cart and form data
$cart = $_SESSION['cart'] ?? [];
$total = $_POST['total'] ?? null;
$card  = $_POST['card_number'] ?? '';
$exp   = $_POST['expiry_date'] ?? '';
$cvv   = $_POST['cvv'] ?? '';

if (empty($cart) || !$total || !$card || !$exp || !$cvv) {
    // Missing data: send user back to payment page
    header('Location: /payment.php');
    exit;
}

// Build order payload
$order = [
    'user'      => $_SESSION['username'] ?? 'guest',
    'items'     => $cart,
    'total'     => $total,
    'payment'   => [
        'card_number' => $card,
        'expiry_date' => $exp,
        'cvv'         => $cvv
    ],
    'timestamp' => date('c')
];

// Publish to RabbitMQ
$connection = new AMQPStreamConnection(
    '98.82.149.231', 5672,
    'totc', 'Totc2025'
);
$channel = $connection->channel();
$channel->queue_declare(
    'payments',    // queue name
    false, true, false, false
);

$msg = new AMQPMessage(
    json_encode($order),
    ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
);

$channel->basic_publish($msg, '', 'payments');
$channel->close();
$connection->close();

// Clear the cart so it doesn’t persist
unset($_SESSION['cart']);

// Redirect to confirmation
header('Location: /confirmation.php');
exit;
