<?php
// frontend/includes/header_user.php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/backend/api/cart_sync.php';
refreshCart();              // only if $_SESSION['cart'] is empty
$cartCount = count($_SESSION['cart'] ?? []);
$active    = basename($_SERVER['PHP_SELF']);
$cartCount = isset($_SESSION['cart']) && is_array($_SESSION['cart'])
           ? count($_SESSION['cart'])
           : 0;
?>
<nav class="navbar" id="site-nav">
  <button class="hamburger" id="hamburger">&#9776;</button>

  <div class="nav-left">
    <a href="/index.php" class="logo">
      <img src="/images/TOC_Logo.png" alt="Taste of the Caribbean">
      <span class="brand">Taste of the Caribbean</span>
    </a>
  </div>

  <div class="nav-right">
    <a href="/index.php" class="<?= $active=='index.php' ? 'active':'' ?>">Home</a>
    <a href="/menu.php"  class="<?= $active=='menu.php'  ? 'active':'' ?>">Menu</a>
    <a href="/map.php"   class="<?= $active=='map.php'   ? 'active':'' ?>">Map</a>
    <a href="/contact.php" class="<?= $active=='contact.php'? 'active':'' ?>">Catering</a>
    <!-- <a href="/about.php" class="<?= $active=='about.php'   ? 'active':'' ?>">About Us</a> -->

    <!-- Profile Icon -->
    <a href="/profile.php" class="icon-link <?= $active=='profile.php'?'active':'' ?>" title="Profile">
      <img src="/images/profile.svg" alt="Profile">
      <a href="/logout.php"  class="<?= $active=='logout.php' ? 'active':'' ?>">Logout</a>
    </a>

    <!-- Cart Icon -->
    <a href="/cart.php" class="cart-icon <?= $active=='cart.php'?'active':'' ?>" title="Cart">
      <img src="/images/cart_icon.png" alt="Cart">
      <?php if($cartCount): ?>
        <span class="cart-count"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>
  </div>
</nav>

<script>
  document.getElementById('hamburger').addEventListener('click', ()=>{
    document.getElementById('site-nav').classList.toggle('open');
  });
</script>
