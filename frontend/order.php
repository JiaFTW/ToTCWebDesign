<?php
// frontend/order.php
session_start();
include 'scripts/check-services.php';
include isset($_SESSION['username'])
  ? 'includes/header_user.php'
  : 'includes/header_guest.php';

$item_id = intval($_GET['item_id'] ?? 0);
require __DIR__ . '/backend/api/database.php';
$db = getDB();
$stmt = $db->prepare('SELECT item_name, price FROM menu_items WHERE id=:id');
$stmt->execute(['id'=>$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
  die("<p>Item not found. <a href='menu.php'>Back to Menu</a></p>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order <?=htmlspecialchars($item['item_name'])?></title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/menu2.css">
</head>
<body>
  <div class="container py-5">
    <h2>Order: <?=htmlspecialchars($item['item_name'])?></h2>
    <form action="payment.php" method="GET">
      <input type="hidden" name="item_id" value="<?=$item_id?>">

      <div class="form-group">
        <label>Quantity:</label>
        <input type="number" name="qty" value="1" min="1" class="form-control">
      </div>

      <div class="form-group">
        <label>Size:</label><br>
        <select name="size" class="form-control w-25">
          <option value="s">Small</option>
          <option value="m">Medium</option>
          <option value="l">Large</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Proceed to Payment</button>
    </form>
  </div>
</body>
</html>
