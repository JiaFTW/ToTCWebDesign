<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// backend/api/create_checkout_session.php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

// Guard: login + CSRF
if (!isset($_SESSION['username']) ||
    ($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')
) {
    http_response_code(403);
    exit('Forbidden');
}

// Build line items from cart
$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    header('Location: /menu.php'); exit;
}

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$line_items = [];
foreach ($cart as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => ['name'=>$item['name']],
            'unit_amount'=> intval($item['price']*100),
        ],
        'quantity' => $item['quantity'],
    ];
}

// Create session
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items'           => $line_items,
    'mode'                 => 'payment',
    'success_url'          => "{$_ENV['APP_DOMAIN']}/success.php?session_id={CHECKOUT_SESSION_ID}",
    'cancel_url'           => "{$_ENV['APP_DOMAIN']}/cancel.php",
]);

header("HTTP/1.1 303 See Other");
header("Location: {$session->url}");
exit;
