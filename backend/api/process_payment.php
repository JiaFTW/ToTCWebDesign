<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Charge;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 1) Gather & validate cart + form
$cart  = $_SESSION['cart'] ?? [];
$total = $_POST['total'] ?? null;
$card  = $_POST['card_number'] ?? '';
$exp   = $_POST['expiry_date'] ?? '';
$cvv   = $_POST['cvv'] ?? '';
$user  = $_SESSION['username'] ?? 'guest';

if (empty($cart) || !$total || !$card || !$exp || !$cvv) {
    header('Location: /payment.php');
    exit;
}

// 2) Charge via Stripe
Stripe::setApiKey('sk_test_YOUR_SECRET_KEY');

try {
    $charge = Charge::create([
        'amount'      => intval($total * 100), // in cents
        'currency'    => 'usd',
        'source'      => [
            'object'        => 'card',
            'number'        => $card,
            'exp_month'     => explode('-', $exp)[1],
            'exp_year'      => explode('-', $exp)[0],
            'cvc'           => $cvv
        ],
        'description' => "Order for {$user}"
    ]);
} catch (\Exception $e) {
    // Payment failed: send back with error
    $_SESSION['payment_error'] = $e->getMessage();
    header('Location: /payment.php');
    exit;
}

// 3) Enqueue order for restaurant
$order = [
    'user'      => $user,
    'items'     => $cart,
    'total'     => $total,
    'charge_id' => $charge->id,
    'timestamp' => date('c'),
];

$connection = new AMQPStreamConnection(
    '98.82.149.231', 5672, 'totc', 'Totc2025'
);
$channel = $connection->channel();
$channel->queue_declare('orders', false, true, false, false);

$msg = new AMQPMessage(
    json_encode($order),
    ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
);

$channel->basic_publish($msg, '', 'orders');
$channel->close();
$connection->close();

// 4) Persist in database for records
require __DIR__ . '/database.php';
$db = getDB();
$stmt = $db->prepare(
  'INSERT INTO orders (user_id,total,charge_id,created_at)
   VALUES (:user,:total,:cid,NOW())'
);
$stmt->execute([
  'user'  => $user,
  'total' => $total,
  'cid'   => $charge->id
]);

// 5) Clear cart & redirect
unset($_SESSION['cart']);
header('Location: /confirmation.php');
exit;
