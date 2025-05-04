<?php
// admin/order.php
session_start();
if (empty($_SESSION['is_admin'])) {
  header('Location: login.php'); exit;
}
require_once __DIR__ . '/../backend/api/database.php';
$db = getDB();

$orderId = intval($_GET['id'] ?? 0);
$stmt = $db->prepare("SELECT item_name, quantity, price FROM order_items WHERE order_id=:id");
$stmt->execute(['id'=>$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch order header
$h = $db->prepare("SELECT o.order_id,u.email,o.total,o.created_at
                   FROM orders o JOIN users u ON o.user_id=u.user_id
                   WHERE order_id=:id");
$h->execute(['id'=>$orderId]);
$hdr = $h->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order #<?= $hdr['order_id'] ?> • Details</title>
  <style>
    body { font-family: sans-serif; padding:2rem; }
    table{width:100%;border-collapse:collapse;margin-top:1rem}
    th,td{border:1px solid #ccc;padding:.5rem;}
    th{background:#007a87;color:#fff;}
  </style>
</head>
<body>
  <a href="orders.php">&larr; Back to list</a>
  <h2>Order #<?= $hdr['order_id'] ?></h2>
  <p>
    Customer: <?= htmlspecialchars($hdr['email']) ?><br>
    Placed:   <?= $hdr['created_at'] ?><br>
    Total:    $<?= number_format($hdr['total'],2) ?>
  </p>
  <table>
    <thead><tr><th>Item</th><th>Qty</th><th>Price (each)</th></tr></thead>
    <tbody>
      <?php foreach($items as $it): ?>
      <tr>
        <td><?= htmlspecialchars($it['item_name']) ?></td>
        <td><?= $it['quantity'] ?></td>
        <td>$<?= number_format($it['price'],2) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
