<?php
// frontend/profile.php
session_start();
include __DIR__.'/scripts/check-services.php';
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login'] = '/profile.php';
    header('Location:/login.php');
    exit;
}
include __DIR__.'/includes/header_user.php';
require __DIR__.'/backend/api/database.php';

$db = getDB();
// 1) Get user info
$stmt = $db->prepare(
  "SELECT full_name,email,phone,loyalty_points,created_at
   FROM users WHERE email=:e"
);
$stmt->execute(['e'=>$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 2) Get orders
$stmt = $db->prepare(
  "SELECT order_id,total,created_at 
   FROM orders 
   WHERE user_id=(SELECT user_id FROM users WHERE email=:e)
   ORDER BY created_at DESC"
);
$stmt->execute(['e'=>$_SESSION['username']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/profile.css">
</head>
<body>
  <div class="profile-container">
    <h2>Your Profile</h2>
    <div class="userinfo">
      <p><strong>Name:</strong> <?=htmlspecialchars($user['full_name'])?></p>
      <p><strong>Email:</strong> <?=htmlspecialchars($user['email'])?></p>
      <p><strong>Phone:</strong> <?=htmlspecialchars($user['phone']?:'—')?></p>
      <p><strong>Member Since:</strong> <?=$user['created_at']?></p>
      <p><strong>Loyalty Points:</strong> <?=$user['loyalty_points']?></p>
    </div>

    <h3>Purchase History</h3>
    <?php if (empty($orders)): ?>
      <p>No orders yet.</p>
    <?php else: ?>
      <table class="history-table">
        <thead><tr><th>ID</th><th>Date</th><th>Total</th></tr></thead>
        <tbody>
          <?php foreach($orders as $o): ?>
          <tr>
            <td><?=$o['order_id']?></td>
            <td><?=$o['created_at']?></td>
            <td>$<?=number_format($o['total'],2)?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
