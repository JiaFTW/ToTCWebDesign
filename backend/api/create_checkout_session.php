<?php
// backend/api/create_checkout_session.php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use Stripe\Stripe;
use Stripe\Checkout\Session;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

/* ── guards ─────────────────────────────────────────── */
if (
    !isset($_SESSION['username']) ||
    ($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')
) {
    http_response_code(403);
    exit('Forbidden');
}

/* ── cart → Stripe line‑items ───────────────────────── */
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location:/menu.php'); exit; }

Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$lines = array_map(static function ($i) {
    return [
        'price_data' => [
            'currency'     => 'usd',
            'product_data' => ['name' => $i['name']],
            'unit_amount'  => intval($i['price'] * 100),
        ],
        'quantity' => $i['quantity'],
    ];
}, $cart);

/* ── create session ────────────────────────────────── */
$session = Session::create([
    'payment_method_types' => ['card'],
    'line_items'           => $lines,
    'mode'                 => 'payment',
    'customer_email'       => $_SESSION['username'],
    'success_url'          => $_ENV['APP_DOMAIN'].'/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url'           => $_ENV['APP_DOMAIN'].'/cart.php',
]);

header('HTTP/1.1 303 See Other');
header('Location: '.$session->url);
