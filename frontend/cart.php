<?php
session_start();
// Health check
include __DIR__ . '/scripts/check-services.php';

// Enforce login
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login'] = '/cart.php';
    header('Location: /login.php');
    exit;
}

// Shared navbar
include __DIR__ . '/includes/header_user.php';

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Load cart
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/cart.css">
</head>
<body>

  <h2>Your Cart</h2>
  <div class="cart-container">

    <?php if (empty($cart)): ?>
      <p>Your cart is empty. <a href="menu.php">Browse our menu</a> to add items!</p>

    <?php else: ?>
      <table class="cart-table">
        <thead> 
          <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $subtotal = 0;
          foreach ($cart as $item):
            $line = $item['price'] * $item['quantity'];
            $subtotal += $line;
          ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td>$<?= number_format($item['price'],2) ?></td>
              <td><?= $item['quantity'] ?></td>
              <td>$<?= number_format($line,2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php
        $tax   = round($subtotal * 0.08, 2);
        $total = round($subtotal + $tax, 2);
        // Loyalty: 1 point per whole dollar
        $pointsEarned = floor($total);
      ?>
      <div class="cart-summary">
        <p>Subtotal: $<?= number_format($subtotal,2) ?></p>
        <p>Tax (8%): $<?= number_format($tax,2) ?></p>
        <p><strong>Total: $<?= number_format($total,2) ?></strong></p>

        <!-- loyalty prompt -->
        <p class="loyalty">
          You’ll earn <strong><?= $pointsEarned ?></strong> loyalty points on this order.
        </p>

        <div class="payment-options">
          <!-- Stripe -->
          <form action="/backend/api/create_checkout_session.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button type="submit" class="btn-stripe">
              <img src="/images/stripe_logo.png" alt="Pay with Stripe">
            </button>
          </form>

          <!-- Toast POS -->
          <form action="/backend/api/process_toast_payment.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button type="submit" class="btn-toast">
              <img src="/images/toast_logo.png" alt="Pay with Toast POS">
            </button>
          </form>
        </div>
      </div>
    <?php endif; ?>

    <form action="backend/api/clear_cart.php" method="POST">
      <button type="submit" class="clear-cart">Clear Cart</button>
    </form>
  </div>

  <div class="footerc">
    <p>&copy; Taste of the Caribbean 2025</p>
  </div>
</body>
</html>
