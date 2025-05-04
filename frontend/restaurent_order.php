<?php
session_start();
// Only staff should see this.
// For now, we just require a logged in user:
if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

include __DIR__ . '/scripts/check-services.php';
require __DIR__ . '/backend/api/database.php';

$db = getDB();

// Fetch all recent orders
$stmt = $db->query("
    SELECT 
      o.order_id,
      o.stripe_session_id,
      u.email AS customer_email,
      o.total,
      o.created_at
    FROM orders o
    JOIN users u ON u.user_id = o.user_id
    ORDER BY o.created_at DESC
");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Incoming Online Orders • Taste of the Caribbean</title>
  <meta http-equiv="refresh" content="30"> <!-- auto-refresh -->
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/orders_admin.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header_user.php'; ?>

  <main class="orders-page">
    <h1>Incoming Online Orders</h1>
    <?php if (empty($orders)): ?>
      <p class="no-orders">No orders received yet.</p>
    <?php else: ?>
      <?php foreach ($orders as $order): ?>
        <section class="order-block">
          <header>
            <div><strong>Order #<?= htmlspecialchars($order['order_id']) ?></strong></div>
            <div>Customer: <?= htmlspecialchars($order['customer_email']) ?></div>
            <div>Total: $<?= number_format($order['total'],2) ?></div>
            <div>Time: <?= htmlspecialchars($order['created_at']) ?></div>
          </header>
          <table class="items-table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Qty</th>
                <th class="right">Price</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $itm = $db->prepare(
                  "SELECT item_name, quantity, price 
                     FROM order_items 
                    WHERE order_id = ?"
                );
                $itm->execute([$order['order_id']]);
                foreach ($itm->fetchAll(PDO::FETCH_ASSOC) as $row): 
              ?>
                <tr>
                  <td><?= htmlspecialchars($row['item_name']) ?></td>
                  <td><?= (int)$row['quantity'] ?></td>
                  <td class="right">$<?= number_format($row['price'],2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
