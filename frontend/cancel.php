<?php
session_start();
include __DIR__.'/scripts/check-services.php';
include __DIR__.'/includes/header_user.php';
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Cancelled • Taste of the Caribbean</title>
<link rel="stylesheet" href="css/navbar.css"><style>
.cancel{max-width:500px;margin:80px auto;text-align:center;}
</style>
</head>
<body>
  <div class="cancel">
    <h2>Payment Cancelled</h2>
    <p>Your order was not placed. <a href="/cart.php">Return to cart</a> to try again.</p>
  </div>
</body>
</html>
