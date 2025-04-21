<?php
// frontend/includes/header_user.php
session_start();
$active    = basename($_SERVER['PHP_SELF']);
$cartCount = $_SESSION['cart'] ? count($_SESSION['cart']) : 0;
?>
<nav class="navbar">
  <div class="nav-left">
    <!-- Logo -->
    <a href="/index.php" class="logo">
      <img src="/images/TOC_Logo.png" alt="Taste of the Caribbean">
    </a>
    <!-- Main Links -->
    <a href="/index.php"   class="<?= $active=='index.php'   ? 'active':'' ?>">Home</a>
    <a href="/menu.php"    class="<?= $active=='menu.php'    ? 'active':'' ?>">Menu</a>
    <a href="/map.php"     class="<?= $active=='map.php'     ? 'active':'' ?>">Map</a>
    <a href="/about.php"   class="<?= $active=='about.php'   ? 'active':'' ?>">About Us</a>
  </div>

  <div class="nav-right">
    <!-- User Links -->
    <a href="/profile.php" class="<?= $active=='profile.php' ? 'active':'' ?>">Profile</a>
    <a href="/logout.php"  class="<?= $active=='logout.php'  ? 'active':'' ?>">Logout</a>

    <!-- Cart Icon -->
    <a href="/cart.php" class="cart-icon">
      <img src="/images/cart_icon.png" alt="Cart">
      <?php if($cartCount): ?>
        <span class="cart-count"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>
  </div>
</nav>
