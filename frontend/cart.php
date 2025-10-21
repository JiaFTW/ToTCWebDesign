<?php
session_start();
// Health check
include __DIR__ . '/scripts/check-services.php';
include __DIR__ . '/backend/api/cart_sync.php';
refreshCart(true); // Sync cart with DB if logged in

// Enforce login
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login'] = '/cart.php';
    header('Location: /login.php');
    exit;
}

// Hydrate cart from DB if needed
if (!isset($_SESSION['cart']) && !empty($_SESSION['username'])) {
  require_once __DIR__.'/backend/api/database.php';
  $db = getDB();
  $stmt = $db->prepare("
      SELECT cart FROM user_carts
      JOIN users USING(user_id)
      WHERE email = ?
  ");
  $stmt->execute([$_SESSION['username']]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $_SESSION['cart'] = json_decode($row['cart'], true) ?: [];
  }
}

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

  <!-- Single unified stylesheet -->
  <link rel="stylesheet" href="css/gstyles.css">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  <?php
    if (isset($_SESSION['username'])) {
      include __DIR__ . '/includes/header_user.php';
    } else {
      include __DIR__ . '/includes/header_guest.php';
    }
  ?>

  <main>
    <section class="cart-container">
      <h2>Your Cart</h2>

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
          $pointsEarned = 0;
          foreach ($cart as $item) {
              $pointsEarned += floor($item['price'] * $item['quantity']);
          }
        ?>
        <div class="cart-summary">
          <p>Subtotal: $<?= number_format($subtotal,2) ?></p>
          <p>Tax (8%): $<?= number_format($tax,2) ?></p>
          <p><strong>Total: $<?= number_format($total,2) ?></strong></p>

          <p class="loyalty">
            You’ll earn <strong><?= $pointsEarned ?></strong> loyalty points on this order.
          </p>

          <h4 class="pay-title">Pay with:</h4>
          <div class="payment-options">
            <!-- Stripe -->
            <form action="/backend/api/create_checkout_session.php" method="POST">
              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <button type="submit" class="pay-btn btn-stripe" title="Stripe Checkout">
                <img src="/images/stripe.svg" class="pay-logo" alt="Stripe">
              </button>
            </form>

            <!-- Toast POS -->
            <form action="/backend/api/process_toast_payment.php" method="POST">
              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <button type="submit" class="pay-btn btn-toast" title="Toast POS">
                <img src="/images/toast.svg" class="pay-logo" alt="Toast POS">
              </button>
            </form>
          </div>
        </div>
      <?php endif; ?>

      <form action="backend/api/clear_cart.php" method="POST" class="clear-cart-form">
        <button type="submit" class="clear-cart">Clear Cart</button>
      </form>
    </section>
  </main>

  <?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
