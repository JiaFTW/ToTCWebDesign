<?php 
session_start();
include __DIR__ . '/scripts/check-services.php';
$active = basename($_SERVER['PHP_SELF']); // for the nav active state
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery | Taste of the Caribbean Restaurant & Catering</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Your main site stylesheet -->
  <link rel="stylesheet" href="/css/global.css">

  <!-- Delivery page stylesheet -->
  <link rel="stylesheet" href="/css/deliver.css">
</head>
<body>

<?php
if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}
?>

<main class="delivery-page">
  <div class="delivery-inner">
    <h1>Order Delivery</h1>
    <p class="delivery-text">
      Enjoy Taste of the Caribbean from home. Choose your favorite delivery app below.
    </p>

    <div class="delivery-apps">
      <a href="https://www.ubereats.com/store/taste-of-the-caribbean-restaurant-%26-catering/TgRJIF_ZRN-q-sTH0nkpmw?diningMode=DELIVERY&pl=JTdCJTIyYWRkcmVzcyUyMiUzQSUyMjI1MSUyMFN0dXl2ZXNhbnQlMjBBdmUlMjIlMkMlMjJyZWZlcmVuY2UlMjIlM0ElMjI0MDcwNTU4Zi04N2I2LTVhMDYtMjVmZC04ODczMDgyZjIzNTAlMjIlMkMlMjJyZWZlcmVuY2VUeXBlJTIyJTNBJTIydWJlcl9wbGFjZXMlMjIlMkMlMjJsYXRpdHVkZSUyMiUzQTQwLjczNzgzMSUyQyUyMmxvbmdpdHVkZSUyMiUzQS03NC4yMzIxMjElN0Q%3D&ps=1&sc=SEARCH_SUGGESTION" class="delivery-card" target="_blank" rel="noopener">
        Uber Eats
      </a>
      <a href="https://www.doordash.com/store/taste-of-the-caribbean-restaurant-&-catering-newark-34154629/77941355/?event_type=autocomplete&pickup=false" class="delivery-card" target="_blank" rel="noopener">
        DoorDash
      </a>
      <a href="https://www.grubhub.com/restaurant/taste-of-the-caribbean-restaurant--catering-4-branford-pl-newark/11330840" class="delivery-card" target="_blank" rel="noopener">
        Grubhub
      </a>
    </div>
  </div>
</main>

<?php include __DIR__ . '/frontend/includes/footer.php'; ?>

</body>
</html>
