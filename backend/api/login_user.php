<?php
// backend/api/login_user.php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//  Capture credentials ─────────────────────────────────────────
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

//  Publish login request to RabbitMQ (unchanged) ───────────────
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel    = $connection->channel();
$channel->queue_declare('user_requests', false, true, false, false);

$payload = json_encode([
    'action'   => 'login',
    'username' => $email,
    'password' => $password
]);
$channel->basic_publish(
    new AMQPMessage($payload, ['delivery_mode' => 2]),
    '',
    'user_requests'
);
$channel->close();
$connection->close();

// Simulate successful login until consumer reply is coded ─────
$_SESSION['username'] = $email;

// Restore saved cart (if any) ─────────────────────────────────
try {
    require_once __DIR__ . '/database.php';
    $db = getDB();

    // get user_id
    $u = $db->prepare('SELECT user_id FROM users WHERE email = ?');
    $u->execute([$email]);
    if ($row = $u->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['user_id'];

        // fetch cart JSON (if exists)
        $c = $db->prepare('SELECT cart FROM user_carts WHERE user_id = ?');
        $c->execute([$uid]);
        if ($cartRow = $c->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['cart'] = json_decode($cartRow['cart'], true);
        }
    }
} catch (Exception $e) {
    // Log but continue redirecting
    error_log('Cart restore error: ' . $e->getMessage());
}

//  Redirect home with absolute URI ─────────────────────────────
header('Location: /index.php');
exit;
