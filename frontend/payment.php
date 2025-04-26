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

//CHANGE THIS WITH THE RIGHT WAY TO CONNECT TO THE SERVER (IN BETWEEN ***)
// ***
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $db = getDB();
// ***
  // Fetch loyalty points
  $stmt = $db->prepare("SELECT loyalty_points FROM users WHERE user_id = :user_id");
  $stmt->execute([':user_id' => $user_id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
      $loyalty_points = intval($user['loyalty_points']);
      $max_redeemable_dollars = min($loyalty_points / 100.0, $total_amount);
      $max_redeemable_points = intval($max_redeemable_dollars * 100);
  }
}
?>
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

        <!--THIS IS OPTION IF USER IS LOGGED IN (LOYAL POINTS)-->
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Your Points: <?php echo $loyalty_points; ?> (=$<?php echo number_format($loyalty_points / 100.0, 2); ?>)</p>

            <label>
                <input type="checkbox" name="redeem_points_checkbox" id="redeem_points_checkbox" onchange="toggleRedemption()" />
                Redeem Points
            </label><br>

            <div id="redeem_input_section" style="display: none;">
                <label for="redeem_points_amount">
                    Enter points to redeem (Max: <?php echo $max_redeemable_points; ?>):
                </label>
                <input type="number" 
                       name="redeem_points_amount" 
                       id="redeem_points_amount" 
                       min="0" 
                       max="<?php echo $max_redeemable_points; ?>" /><br>
            </div>
        <?php endif; ?>

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

      <script>
        function toggleRedemption() {
            const checkbox = document.getElementById('redeem_points_checkbox');
            const redeemInputSection = document.getElementById('redeem_input_section');
            if (checkbox.checked) {
                redeemInputSection.style.display = 'block';
            } else {
                redeemInputSection.style.display = 'none';
            }
        }
      </script>
    <?php endif; ?>
  </div>
</body>
</html>
