<?php
// /var/www/html/success.php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/backend/api/database.php';

use Dotenv\Dotenv;

// load env & Stripe key
Dotenv::createImmutable(__DIR__)->load();
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// validate incoming session_id
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
$order = $o->fetch(PDO::FETCH_ASSOC) ?: [];
$orderId = $order['order_id'] ?? '—';
$total   = $order['total']    ?? 0.00;

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
$loyalty = $l->fetchColumn() ?: 0;

// 4) Clear the session cart
unset($_SESSION['cart']);
require_once __DIR__ . '/backend/api/cart_sync.php';
clearCartStorage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Receipt • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/global.css">
  <style>
    .receipt {
      max-width:600px; margin:90px auto 40px;
      background:#ffcebd; padding:24px;
      border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,.1);
      font-family:"DM Sans",sans-serif; color:#333;
    }
    .receipt h2 { color:#007a87; margin-bottom:12px; }
    .receipt table { width:100%; border-collapse:collapse; margin:14px 0; }
    .receipt th, .receipt td {
      padding:8px; border-bottom:1px solid #e5e5e5; text-align:left;
    }
    .receipt .total { font-weight:700; }
    .btn-home {
      display:inline-block; margin-top:22px;
      padding:10px 24px; background:#56aab3;
      color:#fff; text-decoration:none; border-radius:5px;
    }
    .loyalty {
      margin-top:10px; color:#007a87; font-weight:600;
    }
  </style>
</head>
<body>
  <?php
    if (isset($_SESSION['username'])) {
      include __DIR__ . '/includes/header_user.php';
    } else {
      include __DIR__ . '/includes/header_guest.php';
    }
  ?>
  <div class="receipt">
    <h2>Thank you for your order!</h2>
    <p>
      Order ID: <strong><?= htmlspecialchars($orderId) ?></strong><br>
      Paid by:  <strong><?= htmlspecialchars($user) ?></strong>
    </p>

    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Qty</th>
          <th style="text-align:right">Price</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['item_name']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td style="text-align:right">
              $<?= number_format($row['price'], 2) ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr class="total">
          <td colspan="2" style="text-align:right">Total:</td>
          <td style="text-align:right">$<?= number_format($total, 2) ?></td>
        </tr>
      </tbody>
    </table>

    <p class="loyalty">
      Your current loyalty balance: <strong><?= $loyalty ?></strong> points
    </p>

    <a href="/index.php" class="btn-home">Return Home</a>
  </div>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
