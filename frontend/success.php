<?php
// /var/www/html/success.php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/backend/api/database.php';
require_once __DIR__ . '/backend/api/cart_sync.php';

use Dotenv\Dotenv;

// Load env & Stripe key
Dotenv::createImmutable(__DIR__)->load();
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// Validate incoming session_id
$sessionId = $_GET['session_id'] ?? '';
if (!$sessionId) {
    header('Location:/');
    exit;
}

// 1) Look up the numeric order in our DB
$db = getDB();
$o = $db->prepare("
  SELECT order_id, total
    FROM orders
   WHERE stripe_session_id = ?
");
$o->execute([$sessionId]);
$order   = $o->fetch(PDO::FETCH_ASSOC) ?: [];
$orderId = $order['order_id'] ?? '—';
$total   = (float)($order['total'] ?? 0.00);

// 2) Fetch the individual items for that order
$i = $db->prepare("
  SELECT item_name, quantity, price
    FROM order_items
   WHERE order_id = ?
");
$i->execute([$orderId]);
$items = $i->fetchAll(PDO::FETCH_ASSOC);

// 3) Get updated loyalty balance
$user = $_SESSION['username'] ?? '';
$l = $db->prepare("SELECT loyalty_points FROM users WHERE email = ?");
$l->execute([$user]);
$loyalty = (int)($l->fetchColumn() ?: 0);

// 4) Clear the session cart
unset($_SESSION['cart']);
clearCartStorage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Receipt • Taste of the Caribbean</title>

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

  <main class="contact-container">
    <!-- Receipt Card -->
    <section class="contact-card">
      <header>
        <h1>Thank you for your order!</h1>
      </header>

      <div class="contact-form">
        <p>
          Order ID: <strong><?= htmlspecialchars($orderId) ?></strong><br>
          Paid by:  <strong><?= htmlspecialchars($user ?: 'Guest') ?></strong>
        </p>

        <table class="cart-table" style="margin-top:12px;">
          <thead>
            <tr>
              <th>Item</th>
              <th>Qty</th>
              <th style="text-align:right;">Price</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= (int)$row['quantity'] ?></td>
                <td style="text-align:right;">
                  $<?= number_format((float)$row['price'], 2) ?>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="2" style="text-align:right; font-weight:700;">Total:</td>
              <td style="text-align:right; font-weight:700;">
                $<?= number_format($total, 2) ?>
              </td>
            </tr>
          </tbody>
        </table>

        <p class="info-pill" style="margin-top:10px;">
          Current loyalty balance: <strong><?= $loyalty ?></strong> points
        </p>

        <div class="form-actions" style="margin-top:14px;">
          <a href="/index.php" class="btn">Return Home</a>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
