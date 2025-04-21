<?php
session_start();
include __DIR__ . '/scripts/check-services.php';

if (isset($_SESSION['username'])) {
  include __DIR__ . '/includes/header_user.php';
} else {
  include __DIR__ . '/includes/header_guest.php';
}
include isset($_SESSION['username'])
  ? 'includes/header_user.php'
  : 'includes/header_guest.php';
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Order • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/menu.css">
</head>
<body>
  <div class="container py-5">
    <h2>Your Order</h2>
    <?php if (empty($cart)): ?>
      <p>Your order is empty. <a href="menu.php">Browse Menu</a></p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>Item</th><th>Size</th>
            <th>Price</th><th>Qty</th><th>Total</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sum = 0;
        foreach($cart as $it):
          $tot = $it['price']*$it['quantity'];
          $sum += $tot;
        ?>
          <tr>
            <td><?= htmlspecialchars($it['name']) ?></td>
            <td><?= strtoupper($it['size']) ?></td>
            <td>$<?= number_format($it['price'],2) ?></td>
            <td><?= $it['quantity'] ?></td>
            <td>$<?= number_format($tot,2) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div class="text-right">
        <h4>Subtotal: $<?= number_format($sum,2) ?></h4>
        <a href="payment.php" class="btn btn-success">Proceed to Payment</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
