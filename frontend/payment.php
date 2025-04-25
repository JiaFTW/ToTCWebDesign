<?php
session_start();
// Critical services health-check
include __DIR__ . '/scripts/check-services.php';

// Shared navbar
if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}

//ADDED BY DIEGO FROM CHECKOUT2.PHP
if (isset($_POST['total_amount'])) {
  $total = floatval($_POST['total_amount']);
} else {
  $total = 0.00;
}

$loyalty_points = 0;
$max_redeemable_points = 0;

// Grab the cart from session
$cart = $_SESSION['cart'] ?? [];

// Compute totals
$subtotal = array_reduce(
    $cart,
    fn($sum, $item) => $sum + ($item['price'] * $item['quantity']),
    0
);
$tax   = round($subtotal * 0.06625, 2);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/cart.css"> <!-- reuse your cart styles -->
  <style>
    .payment-container { max-width:600px; margin:40px auto; font-family:"DM Sans",sans-serif; }
    .payment-summary p { margin:8px 0; font-size:1rem; }
    .payment-form { margin-top:20px; }
    .payment-form .form-group { margin-bottom:15px; }
    .payment-form label { display:block; margin-bottom:5px; font-weight:500; }
    .payment-form input { width:100%; padding:8px; box-sizing:border-box; }
    .btn-submit { margin-top:10px; }
  </style>
</head>
<body>
  <div class="payment-container">
    <h2>Checkout</h2>

    <?php if (empty($cart)): ?>
      <p>Your cart is empty. <a href="menu.php">Browse our menu</a>.</p>
    <?php else: ?>
      <div class="payment-summary">
        <p>Subtotal: <strong>$<?= number_format($subtotal,2) ?></strong></p>
        <p>Tax (6.625%): <strong>$<?= number_format($tax,2) ?></strong></p>
        <p>Total Due: <strong>$<?= number_format($total,2) ?></strong></p>
      </div>

      <form action="backend/api/process_payment.php" method="POST" class="payment-form">
        <input type="hidden" name="total" value="<?= $total ?>">

        <div class="form-group">
          <label for="card_number">Card Number</label>
          <input type="text" id="card_number" name="card_number" required placeholder="1234 5678 9012 3456">
        </div>

        <div class="form-group">
          <label for="expiry_date">Expiration</label>
          <input type="month" id="expiry_date" name="expiry_date" required>
        </div>

        <div class="form-group">
          <label for="cvv">CVC</label>
          <input type="text" id="cvv" name="cvv" required placeholder="123">
        </div>

        <button type="submit" class="btn btn-success btn-submit">
          Submit Payment
        </button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
