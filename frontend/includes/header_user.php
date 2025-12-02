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
    <a href="/location.php" class="<?= $active=='hours.php' ? 'active':'' ?>">Location</a>
    <a href="/map.php"   class="<?= $active=='map.php'   ? 'active':'' ?>">Map</a>
    <a href="/merch.php"   class="<?= $active=='merch.php'   ? 'active':'' ?>">Merch</a>
    <a href="/contact.php" class="<?= $active=='contact.php'? 'active':'' ?>">Catering</a>
<!-- delivery dropdown -->
    <div class="dropdown">
  <a href="#" class="nav-link dropbtn <?= $active=='delivery.php' ? 'active' : '' ?>">
    Delivery ▾
  </a>
  <div class="dropdown-menu">
    <a href="https://www.ubereats.com/store/taste-of-the-caribbean-restaurant-%26-catering/TgRJIF_ZRN-q-sTH0nkpmw?diningMode=DELIVERY"
       target="_blank" rel="noopener">
      Uber Eats
    </a>
    <a href="https://www.doordash.com/store/taste-of-the-caribbean-restaurant-&-catering-newark-34154629/"
       target="_blank" rel="noopener">
      DoorDash
    </a>
    <a href="https://www.grubhub.com/restaurant/taste-of-the-caribbean-restaurant--catering-4-branford-pl-newark/11330840"
       target="_blank" rel="noopener">
      Grubhub
    </a>
     <a href="https://order.toasttab.com/online/taste-of-the-caribbean-restaurant-and-4-branford-pl"
       target="_blank" rel="noopener">
      In house Delivery
    </a>
  </div>
</div>

<!-- Social Media Icons -->
<div class="social-icons">
  <a href="https://www.instagram.com/tocrestaurant_catering/" target="_blank">
    <img src="/images/instagram.png" alt="Instagram" class="social-icon">
  </a>

  <a href="https://www.facebook.com/tocfoodmarket/" target="_blank">
    <img src="/images/facebook.png" alt="Facebook" class="social-icon">
  </a>
</div>

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
