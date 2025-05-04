<?php
// admin/orders.php
session_start();
if (empty($_SESSION['is_admin'])) {
    header('Location: order_login.php');
    exit;
}
require_once __DIR__ . '/../backend/api/database.php';
$db = getDB();

// Fetch all orders with items
$stmt = $db->query("
  SELECT o.order_id, o.total, o.created_at, u.email
  FROM orders o
  JOIN users u ON u.user_id = o.user_id
  ORDER BY o.created_at DESC
");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Incoming Orders • ToTC Admin</title>
  <style>
    body { font-family: sans-serif; padding:2rem; }
    table { width:100%; border-collapse:collapse; margin-bottom:2rem; }
    th,td { padding:.5rem; border:1px solid #ccc; text-align:left; }
    th { background:#007a87; color:#fff; }
    .logout { float:right; }
  </style>
</head>
<body>
  <h1>Incoming Orders</h1>
  <a href="admin_logout.php" class="logout">Log Out</a>
  <?php if (!$orders): ?>
    <p>No orders yet.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Total ($)</th>
          <th>Placed At</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $o): ?>
        <tr>
          <td><?= $o['order_id'] ?></td>
          <td><?= htmlspecialchars($o['email']) ?></td>
          <td><?= number_format($o['total'],2) ?></td>
          <td><?= $o['created_at'] ?></td>
          <td><a href="order.php?id=<?= $o['order_id'] ?>">View Items</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
