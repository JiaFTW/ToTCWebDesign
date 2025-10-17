<?php
// admin/auth.php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$u = $_POST['user'] ?? '';
$p = $_POST['pass'] ?? '';

if ($u === $_ENV['ADMIN_USER'] && $p === $_ENV['ADMIN_PASS']) {
    $_SESSION['is_admin'] = true;
    header('Location: orders.php');
    exit;
} else {
    header('Location: admin_login.php?error=' . urlencode('Invalid credentials'));
    exit;
}
