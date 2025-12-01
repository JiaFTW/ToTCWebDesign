<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/database.php';
$db = getDB();

/* STEP 1 — Pull data from form */
$email = trim($_POST['email'] ?? '');
$code  = trim($_POST['code'] ?? '');

/* Basic validation */
if (!$email || !$code) {
    die("Invalid request.");
}

/* STEP 2 — Check if user exists */
$stmt = $db->prepare("
    SELECT id, reset_code, reset_expires
    FROM users
    WHERE email = ?
");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Invalid email or verification code.");
}

/* STEP 3 — Verify reset code matches */
if ($user['reset_code'] !== $code) {
    die("Incorrect verification code.");
}

/* STEP 4 — Check if the code is expired */
if (strtotime($user['reset_expires']) < time()) {
    die("Your reset code has expired. Please request a new one.");
}

/* STEP 5 — Code is valid → grant access to new_password.php */
$_SESSION['reset_email'] = $email;

/* Redirect to new password page */
header("Location: /new_password.php");
exit;
