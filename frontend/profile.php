<?php
session_start();
include __DIR__ . '/scripts/check-services.php';

// Force login
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login'] = '/profile.php';
    header('Location: /login.php');
    exit;
}

// Navbar
include __DIR__ . '/includes/header_user.php';

// DB connection
require __DIR__ . '/backend/api/database.php';
$db = getDB();

// Fetch user
$username = $_SESSION['username'];
$stmt = $db->prepare("SELECT id, email, loyalty_points FROM users WHERE username=:u");
$stmt->execute(['u'=>$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch purchase history
$stmt = $db->prepare("
  SELECT id, items, total, purchase_date
    FROM purchases
   WHERE user_id = :uid
   ORDER BY purchase_date DESC
");
$stmt->execute(['uid'=>$user['id']]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h2>Hello, <?= htmlspecialchars($username) ?></h2>
    <p class="points">Your Loyalty Points: <strong><?= $user['loyalty_points'] ?></strong></p>

    <h3>Purchase History</h3>
    <?php if (empty($history)): ?>
      <p>No purchases yet. <a href="menu.php">Order now</a>!</p>
    <?php else: ?>
      <table class="history-table">
        <thead>
          <tr><th>Date</th><th>Items</th><th>Total</th></tr>
        </thead>
        <tbody>
        <?php foreach ($history as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['purchase_date']) ?></td>
            <td>
              <?php 
                $items = json_decode($order['items'], true);
                foreach ($items as $it) {
                  echo htmlspecialchars($it['name']) . " ×{$it['quantity']}<br>";
                }
              ?>
            </td>
            <td>$<?= number_format($order['total'],2) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
