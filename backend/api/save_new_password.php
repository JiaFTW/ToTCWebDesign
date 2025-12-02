<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/database.php';
$db = getDB();

/* STEP 1 — Only allow if session is set */
if (!isset($_SESSION['reset_email'])) {
    die("Unauthorized request.");
}

$email      = $_SESSION['reset_email'];
$password   = $_POST['password'] ?? '';
$confirm_pw = $_POST['confirm_password'] ?? '';

/* STEP 2 — Validate input */
if (!$password || !$confirm_pw) {
    die("Password fields cannot be empty.");
}

if ($password !== $confirm_pw) {
    die("Passwords do not match.");
}

if (strlen($password) < 6) {
    die("Password must be at least 6 characters long.");
}

/* STEP 3 — Hash new password */
$hash = password_hash($password, PASSWORD_BCRYPT);

/* STEP 4 — Update in database */
$stmt = $db->prepare("
    UPDATE users
    SET password_hash = ?, reset_code = NULL, reset_expires = NULL
    WHERE email = ?
");
$stmt->execute([$hash, $email]);

/* STEP 5 — Clear session */
unset($_SESSION['reset_email']);

/* STEP 6 — Give confirmation */
echo "Your password has been successfully updated. You may now log in.";
?>
