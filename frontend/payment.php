<?php
session_start();
include __DIR__ . '/scripts/check-services.php';
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login'] = '/payment.php';
    header('Location: /login.php');
    exit;
}
include __DIR__.'/includes/header_user.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: /menu.php'); exit;
}

// Calculate totals
$subtotal = array_reduce(
  $cart, fn($s,$i)=>$s + $i['price']*$i['quantity'], 0
);
$tax   = round($subtotal * 0.08, 2);
$total = round($subtotal + $tax, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/payment.css">
</head>
<body>
  <div class="payment-container">
    <h2>Checkout</h2>
    <div class="summary">
      <p>Subtotal: $<?=number_format($subtotal,2)?></p>
      <p>Tax (8%): $<?=number_format($tax,2)?></p>
      <p><strong>Total: $<?=number_format($total,2)?></strong></p>
    </div>
    <form action="/backend/api/create_checkout_session.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
      <button type="submit" class="btn-pay">Pay $<?=number_format($total,2)?> with Stripe</button>
    </form>
  </div>
</body>
</html>
