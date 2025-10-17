<?php
// backend/api/login_user.php
session_start();
require_once __DIR__ . '/database.php';

$email    = trim($_POST['email']    ?? '');
$password =           $_POST['password'] ?? '';

// Basic sanity
if (!$email || !$password) {
    $_SESSION['login_error'] = "Please provide both email and password.";
    header("Location: /login.php");
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("SELECT password_hash FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || !password_verify($password, $row['password_hash'])) {
        // wrong email or password
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: /login.php");
        exit;
    }

    // success
    $_SESSION['username'] = $email;

    // restore cart (if you have user_carts table)
    $stmt = $db->prepare("SELECT cart FROM user_carts uc
                          JOIN users u USING(user_id)
                          WHERE u.email = ?");
    $stmt->execute([$email]);
    if ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['cart'] = json_decode($r['cart'], true) ?: [];
    }

    // redirect to intended page
    $dest = $_SESSION['after_login'] ?? '/index.php';
    unset($_SESSION['after_login']);
    header("Location: $dest");
    exit;

} catch (Exception $e) {
    // log & back to login
    error_log("Login error: " . $e->getMessage());
    $_SESSION['login_error'] = "An internal error occurred.";
    header("Location: /login.php");
    exit;
}
