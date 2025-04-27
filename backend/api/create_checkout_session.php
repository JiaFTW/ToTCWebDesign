<?php
session_start();
require_once __DIR__.'/../../vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_YOUR_SECRET_KEY');

// CSRF & login check
if (!isset($_SESSION['username']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Forbidden');
}

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    header('Location: /menu.php'); exit;
}

// Build line items
$line_items = [];
foreach ($cart as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => $item['name'],
            ],
            'unit_amount' => intval($item['price'] * 100),
        ],
        'quantity' => $item['quantity'],
    ];
}

$YOUR_DOMAIN = 'http://98.82.149.231.com';
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items'           => $line_items,
    'mode'                 => 'payment',
    'success_url'          => $YOUR_DOMAIN . '/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url'           => $YOUR_DOMAIN . '/cancel.php',
]);

header("HTTP/1.1 303 See Other");
header("Location: {$session->url}");
