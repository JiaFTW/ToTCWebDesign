<?php
// frontend/includes/header_guest.php
session_start();
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
    <a href="/location.php" class="<?= $active=='hours.php' ? 'active':'' ?>">Location</a>
    <a href="/map.php"   class="<?= $active=='map.php'   ? 'active':'' ?>">Map</a>
    <a href="/contact.php" class="<?= $active=='contact.php'? 'active':'' ?>">Catering</a>
    <!-- <a href="/about.php" class="<?= $active=='about.php'   ? 'active':'' ?>">About Us</a> -->

    <!-- Profile Icon links to login when guest -->
    <a href="/login.php" class="icon-link <?= $active=='login.php'?'active':'' ?>" title="Login / Profile">
      <img src="/images/profile.svg" alt="Profile">
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
