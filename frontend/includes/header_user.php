<?php
// frontend/includes/header_user.php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/backend/api/cart_sync.php';
refreshCart();                              // sync if empty

$active    = basename($_SERVER['PHP_SELF']);
$cartCount = count($_SESSION['cart'] ?? []);
?>
<nav class="navbar" id="site-nav">
  <button class="hamburger" id="hamburger">&#9776;</button>

  <!-- logo & brand -->
  <div class="nav-left">
    <a href="/index.php" class="logo">
      <img src="/images/TOC_Logo.png" alt="Taste of the Caribbean">
      <span class="brand">Taste of the Caribbean</span>
    </a>
  </div>

  <!-- main nav & icons -->
  <div class="nav-right">
    <a href="/index.php" class="<?= $active=='index.php' ? 'active':'' ?>">Home</a>
    <a href="/menu.php"  class="<?= $active=='menu.php'  ? 'active':'' ?>">Menu</a>
    <a href="/map.php"   class="<?= $active=='map.php'   ? 'active':'' ?>">Map</a>
    <a href="/contact.php" class="<?= $active=='contact.php'? 'active':'' ?>">Catering</a>

    <!-- profile icon → profile page -->
  <!-- Profile (always visible when logged-in) -->
  <a href="/profile.php"
    class="icon-link <?= $active=='profile.php'?'active':'' ?>"
    title="Profile">
    <img src="/images/profile.svg" alt="Profile">
  </a>

  <!-- Logout (text or icon, your choice) -->
  <a href="/logout.php"
    class="icon-link"
    title="Logout">
    Logout
  </a>
    <!-- cart icon -->
    <a href="/cart.php"
       class="cart-icon <?= $active=='cart.php'?'active':'' ?>"
       title="Cart">
      <img src="/images/cart_icon.png" alt="Cart">
      <?php if ($cartCount): ?>
        <span class="cart-count"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>
  </div>
</nav>

<script>
document.getElementById('hamburger')
        .addEventListener('click', () =>
            document.getElementById('site-nav').classList.toggle('open'));
</script>
