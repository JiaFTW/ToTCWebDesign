<?php
// frontend/checkout.php
session_start();
include __DIR__ . '/scripts/check-services.php';
if (isset($_SESSION['username'])) {
  include __DIR__ . '/includes/header_user.php';
} else {
  include __DIR__ . '/includes/header_guest.php';
}

$cart = $_SESSION['cart'] ?? [];
$subtotal = array_reduce($cart, fn($s,$i)=>$s+$i['price']*$i['quantity'], 0);
$tax      = round($subtotal*0.08,2);
$total    = round($subtotal+$tax,2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/cart.css">
  <link rel="stylesheet" href="css/payment.css">
  <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
  <div class="checkout-container">
    <h2>Your Order</h2>
    <!-- summary -->
    <div class="payment-summary">
      <p>Subtotal: <strong>$<?=number_format($subtotal,2)?></strong></p>
      <p>Tax (8%): <strong>$<?=number_format($tax,2)?></strong></p>
      <p>Total: <strong>$<?=number_format($total,2)?></strong></p>
    </div>

    <!-- Elements form -->
    <form id="payment-form">
      <div id="card-element"><!-- Stripe Element goes here --></div>
      <button id="submit" class="btn btn-primary">Pay $<?=number_format($total,2)?></button>
      <div id="payment-message" class="hidden"></div>
    </form>
  </div>

  <script>
    const stripe = Stripe('pk_test_YOUR_PUBLISHABLE_KEY');
  </script>
  <script src="js/checkout.js"></script>
</body>
</html>
