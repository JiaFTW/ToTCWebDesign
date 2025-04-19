<?php
// frontend/payment.php
session_start();
include 'scripts/check-services.php';
include isset($_SESSION['username'])
  ? 'includes/header_user.php'
  : 'includes/header_guest.php';

$item_id = intval($_GET['item_id']);
$qty     = intval($_GET['qty']);
$size    = $_GET['size'];
// fetch price
require __DIR__.'/backend/api/database.php';
$db = getDB();
$stmt = $db->prepare('SELECT price FROM menu_items WHERE id=:id');
$stmt->execute(['id'=>$item_id]);
$price = $stmt->fetchColumn() * $qty;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/menu2.css">
</head>
<body>
  <div class="container py-5">
    <h2>Payment</h2>
    <p>Amount: <strong>$<?= number_format($price,2) ?></strong></p>
    <form action="../backend/api/process_payment.php" method="POST">
      <input type="hidden" name="item_id" value="<?=$item_id?>">
      <input type="hidden" name="qty" value="<?=$qty?>">
      <input type="hidden" name="size" value="<?=$size?>">

      <div class="form-group">
        <label>Card Number:</label>
        <input type="text" name="card" class="form-control w-50" required>
      </div>
      <div class="form-group">
        <label>Expiration:</label>
        <input type="month" name="exp" class="form-control w-25" required>
      </div>
      <div class="form-group">
        <label>CVC:</label>
        <input type="text" name="cvc" class="form-control w-25" required>
      </div>

      <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
  </div>
</body>
</html>
