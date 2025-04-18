<?php
session_start();
$activePage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taste of the Caribbean</title>
  <link rel="stylesheet" href="../css/navbar.css"> <!-- 🌟 use shared navbar styling -->
</head>
<body>
  <nav>
    <ul>
      <li><a href="index.php" class="<?= $activePage == 'index.php' ? 'active' : '' ?>">Home</a></li>
      <li><a href="menu2.php" class="<?= $activePage == 'menu2.php' ? 'active' : '' ?>">Menu</a></li>
      <li><a href="map.php" class="<?= $activePage == 'map.php' ? 'active' : '' ?>">Map</a></li>
      <li><a href="order.php" class="<?= $activePage == 'order.php' ? 'active' : '' ?>">Order</a></li>
      <li><a href="profile.php" class="<?= $activePage == 'profile.php' ? 'active' : '' ?>">Profile</a></li>
      <li><a href="login.php" class="<?= $activePage == 'login.php' ? 'active' : '' ?>">Login</a></li>
    </ul>
  </nav>
  </body>
  </html>