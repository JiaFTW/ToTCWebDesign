<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Already logged in?
if (!empty($_SESSION['is_admin'])) {
    header('Location: orders.php');
    exit;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Login • ToTC</title>
  <link rel="stylesheet" href="../css/navbar.css">
  <style>
    body { font-family: sans-serif; padding:2rem; background:#f4f4f4; }
    .login { max-width:320px; margin:5rem auto; background:#fff; padding:2rem; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.1); }
    .login h2 { margin-bottom:1rem; }
    .login input { width:100%; padding:.5rem; margin: .5rem 0; border:1px solid #ccc; border-radius:4px; }
    .login button { width:100%; padding:.7rem; background:#007a87; color:#fff; border:none; border-radius:4px; }
    .error { color:#c00; margin-bottom:1rem; }
  </style>
</head>
<body>
  <div class="login">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="auth.php">
      <input name="user"     type="email"    placeholder="Email"     required>
      <input name="pass"     type="password" placeholder="Password"  required>
      <button type="submit">Log In</button>
    </form>
  </div>
</body>
</html>
