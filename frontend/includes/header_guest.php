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
      <img src="/images/WTOC_Logo.png" alt="Taste of the Caribbean Restaurant & Catering">
      <span class="brand">Taste of the Caribbean Restaurant & Catering</span>
    </a>
  </div>

  <div class="nav-right">
    <a href="/index.php" class="<?= $active=='index.php' ? 'active':'' ?>">Home</a>
    <a href="/menu.php"  class="<?= $active=='menu.php'  ? 'active':'' ?>">Menu</a>
    <a href="/location.php" class="<?= $active=='hours.php' ? 'active':'' ?>">Location</a>
    <a href="/map.php"   class="<?= $active=='map.php'   ? 'active':'' ?>">Map</a>
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

    <!-- <a href="/about.php" class="<?= $active=='about.php'   ? 'active':'' ?>">About Us</a> -->

<!-- Social Media Icons -->
<div class="social-icons">
  <a href="https://www.instagram.com/tocrestaurant_catering/" target="_blank">
    <img src="/images/instagram.png" alt="Instagram" class="social-icon">
  </a>

  <a href="https://www.facebook.com/tocfoodmarket/" target="_blank">
    <img src="/images/facebook.png" alt="Facebook" class="social-icon">
  </a>
</div>

    
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
