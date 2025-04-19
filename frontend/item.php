<?php
session_start();
include __DIR__ . '/scripts/check-services.php';
if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}
$item_id = intval($_GET['item_id'] ?? 0);
require __DIR__ . '/backend/api/database.php';
$db = getDB();
$stmt = $db->prepare(
  'SELECT item_name, description, price, image_name, category
   FROM menu_items WHERE id = :id'
);
$stmt->execute(['id' => $item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $item ? htmlspecialchars($item['item_name']) : 'Item Not Found' ?> • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/menu.css">
</head>
<body>
  <div class="container py-5">
    <?php if (!$item): ?>
      <div class="alert alert-danger">Item not found.</div>
    <?php else: ?>
      <div class="item-detail">
        <!-- Image Column -->
        <div class="img-col">
          <img src="/images/<?= htmlspecialchars($item['image_name']) ?>"
               alt="<?= htmlspecialchars($item['item_name']) ?>">
        </div>

        <!-- Info Column -->
        <div class="info-col">
          <h2><?= htmlspecialchars($item['item_name']) ?></h2>
          <p class="category"><em>Category: <?= htmlspecialchars($item['category']) ?></em></p>
          <p class="description"><?= htmlspecialchars($item['description']) ?></p>
          <h4 class="price">$<?= number_format($item['price'],2) ?></h4>
          <a href="order.php?item_id=<?= $item_id ?>"
             class="order-btn">Order Now</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
