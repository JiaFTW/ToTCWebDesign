<?php
// backend/api/create_checkout_session.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['test'])) {
    require_once __DIR__ . '/database.php';
    $db = getDB();

    echo "<h3>🛠️ Cart Debug:</h3>";
    echo "<pre>";
    print_r($_SESSION['cart']);
    echo "</pre>";

    $cart = $_SESSION['cart'] ?? [];
    if (!$cart) {
        exit("❌ No cart found in session. Add items before testing.");
    }

    $earnedPoints = 0;
    foreach ($cart as $item) {
        $earnedPoints += floor($item['price'] * $item['quantity']);
    }

    echo "<p>✅ Calculated earnedPoints: <strong>{$earnedPoints}</strong></p>";

    $stmt = $db->prepare("UPDATE users SET loyalty_points = loyalty_points + :points WHERE email = :email");
    $stmt->execute([
        ':points' => $earnedPoints,
        ':email' => $_SESSION['username']
    ]);

    echo "<p>✅ Test successful: {$earnedPoints} points added to {$_SESSION['username']}</p>";
    exit;
}



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
