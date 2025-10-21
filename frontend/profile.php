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

  <!-- Single unified stylesheet -->
  <link rel="stylesheet" href="css/gstyles.css">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/includes/header_user.php'; ?>

  <main class="contact-container">
    <!-- Profile card -->
    <section class="contact-card">
      <header>
        <h1>My Profile</h1>
      </header>
      <div class="contact-form">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Phone:</strong> <?= $user['phone'] ? htmlspecialchars($user['phone']) : '—' ?></p>
        <p><strong>Member Since:</strong> <?= htmlspecialchars(substr($user['created_at'], 0, 10)) ?></p>
        <p><strong>Loyalty Points:</strong> <?= (int)$user['loyalty_points'] ?></p>

        <div class="form-actions" style="margin-top: 12px;">
          <a class="btn" href="/logout.php">Logout</a>
        </div>
      </div>
    </section>

    <!-- Order history card -->
    <section class="contact-card">
      <header>
        <h1>Purchase History</h1>
      </header>
      <div class="contact-form">
        <?php if (!$orders): ?>
          <p>No orders yet.</p>
        <?php else: ?>
          <table class="cart-table">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $o): ?>
                <tr>
                  <td><?= (int)$o['order_id'] ?></td>
                  <td><?= htmlspecialchars(substr($o['created_at'], 0, 19)) ?></td>
                  <td>$<?= number_format((float)$o['total'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
