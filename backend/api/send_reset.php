<?php
// backend/api/send_reset.php

require_once __DIR__ . '/../db/database.php';

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("This endpoint only accepts POST requests.");
}

// Get email
$email = trim($_POST['email'] ?? '');
if (!$email) {
    http_response_code(400);
    die("Email is required.");
}

// Connect to DB
$db = getDB();

// Check if user exists
$stmt = $db->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(404);
    die("No account found with that email.");
}

// Generate a secure 6-digit code
$code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
$expires = date("Y-m-d H:i:s", time() + 900); // 15 minutes

// Save into database
$update = $db->prepare("
    UPDATE users 
    SET reset_code = ?, reset_expires = ?
    WHERE user_id = ?
");
$update->execute([$code, $expires, $user['user_id']]);

// TEMPORARY DEBUG OUTPUT (for testing)
echo "Reset code generated: $code";


?>
