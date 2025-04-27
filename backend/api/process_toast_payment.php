<?php
// backend/api/process_toast_payment.php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

// Guard: login + CSRF
if (!isset($_SESSION['username']) ||
    ($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')
) {
    http_response_code(403);
    exit('Forbidden');
}

// Placeholder: here you’d call Toast POS API with your API key
$payload = [
    'user'  => $_SESSION['username'],
    'cart'  => $_SESSION['cart'],
    'api_key' => $_ENV['TOAST_API_KEY']
];
// For now, just log it:
file_put_contents('/var/log/toast_payments.log', json_encode($payload)."\n", FILE_APPEND);

// Clear cart and redirect to success
unset($_SESSION['cart']);
header('Location: /success.php');
exit;
