<?php
session_start();
include __DIR__ . '/scripts/check-services.php';
if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmed • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/footer.css">

  <style>
    .confirm {
      text-align:center;
      margin:80px auto;
      max-width:500px;
      font-family:"DM Sans",sans-serif;
    }
    .confirm h2 {
      color:#007a87;
      margin-bottom:20px;
    }
    .confirm a {
      display:inline-block;
      margin-top:20px;
      color:#ff6b35;
      text-decoration:none;
    }
  </style>
</head>
<body>
  <?php
    if (isset($_SESSION['username'])) {
      include __DIR__.'/includes/header_user.php';
    } else {
      include __DIR__.'/includes/header_guest.php';
    }
  ?>
  <div class="confirm">
    <h2>Thank you! Your order has been placed.</h2>
    <p>We’re preparing your Caribbean dishes now and will notify you shortly.</p>
    <a href="/index.php">Return to Home</a>
  </div>
  <div>
    <?php include __DIR__.'/includes/footer.php'; ?>
  </div> 
</body>
</html>
