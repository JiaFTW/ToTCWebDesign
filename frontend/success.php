<?php
session_start();
include __DIR__.'/scripts/check-services.php';
include __DIR__.'/includes/header_user.php';
require_once __DIR__.'/../vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_YOUR_SECRET_KEY');

$session_id = $_GET['session_id'] ?? '';
if (!$session_id) { header('Location:/'); exit; }

$session = \Stripe\Checkout\Session::retrieve($session_id);
$customer = \Stripe\Customer::retrieve($session->customer);

// Clear cart
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Success • Taste of the Caribbean</title>
<link rel="stylesheet" href="css/navbar.css"><style>
.confirm{max-width:500px;margin:80px auto;text-align:center;}
.confirm h2{color:#007a87;}
</style>
</head>
<body>
  <div class="confirm">
    <h2>Payment Received</h2>
    <p>Thank you, <?=htmlspecialchars($customer->name)?>! We’re preparing your order.</p>
    <a href="/index.php" class="btn-back">Return Home</a>
  </div>
</body>
</html>
