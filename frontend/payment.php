<?php
// frontend/payment.php
session_start();
include __DIR__ . '/scripts/check-services.php';

// 1) Force login
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login'] = '/payment.php';
    header('Location: /login.php');
    exit;
}

// 2) Shared navbar
include __DIR__ . '/includes/header_user.php';

// 3) Load cart
$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    header('Location: /menu.php');
    exit;
}

// 4) Totals
$subtotal = array_reduce($cart, fn($s,$i)=>$s + $i['price']*$i['quantity'], 0);
$tax      = round($subtotal*0.08,2);
$total    = round($subtotal + $tax,2);

// 5) CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
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
    <h2>Finalize Your Order</h2>
    <div class="summary">
      <p>Subtotal: $<?=number_format($subtotal,2)?></p>
      <p>Tax (8%): $<?=number_format($tax,2)?></p>
      <p class="total">Total: $<?=number_format($total,2)?></p>
    </div>

    <div class="payment-options">
      <!-- Stripe Checkout -->
      <form action="/backend/api/create_checkout_session.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button type="submit" class="btn-stripe">
          <img src="/images/stripe_logo.png" alt="Pay with Stripe">
        </button>
      </form>

      <!-- Toast POS (placeholder integration) -->
      <form action="/backend/api/process_toast_payment.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button type="submit" class="btn-toast">
          <img src="/images/toast_logo.png" alt="Pay with Toast">
        </button>
      </form>
    </div>
  </div>
</body>
</html>
