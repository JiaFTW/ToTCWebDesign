<?php
// profile.php — user dashboard
session_start();

// Health check
require_once __DIR__ . '/scripts/check-services.php';

// Must be logged in
if (empty($_SESSION['username'])) {
    $_SESSION['after_login'] = '/profile.php';
    header('Location: /login.php');
    exit;
}

// Database
require_once __DIR__ . '/backend/api/database.php';
$db = getDB();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ── 1. Fetch user info ─────────────────────────
$stmt = $db->prepare("
    SELECT user_id, full_name, email, phone, loyalty_points, created_at
    FROM users
    WHERE email = :e
");
$stmt->execute(['e' => $_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If user row missing, something is wrong — bail gracefully
if (!$user) {
    die('Profile not found.');
}

// ── 2. Fetch order history (may be empty) ───────
$stmt = $db->prepare("
    SELECT order_id, total, created_at
    FROM orders
    WHERE user_id = :uid
    ORDER BY created_at DESC
");
$stmt->execute(['uid' => $user['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/global.css">
</head>
<body>
<?php include __DIR__ . '/includes/header_user.php'; ?>

<main class="profile-container" style="padding-top:100px;">
  <h2>Welcome to Your Profile</h2>

  <section class="userinfo">
    <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?: '—') ?></p>
    <p><strong>Member Since:</strong> <?= substr($user['created_at'], 0, 10) ?></p>
    <p><strong>Loyalty Points:</strong> <?= $user['loyalty_points'] ?></p>
    <p><a class="btn-logout" href="/logout.php">Logout</a></p>
  </section>

  <h3>Purchase History</h3>
  <?php if (!$orders): ?>
      <p>No orders yet.</p>
  <?php else: ?>
      <table class="history-table">
        <thead><tr><th>Order #</th><th>Date</th><th>Total</th></tr></thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
            <tr>
              <td><?= $o['order_id'] ?></td>
              <td><?= substr($o['created_at'], 0, 19) ?></td>
              <td>$<?= number_format($o['total'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
  <?php endif; ?>
</main>

  <div>
    <?php include __DIR__.'/includes/footer.php'; ?>
  </div> </body>
</html>
