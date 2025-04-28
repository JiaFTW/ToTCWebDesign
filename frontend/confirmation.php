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
  <div class="confirm">
    <h2>Thank you! Your order has been placed.</h2>
    <p>We’re preparing your Caribbean dishes now and will notify you shortly.</p>
    <a href="/index.php">Return to Home</a>
  </div>
  <div class="footer">
		<p> &copy; Taste of the Caribbean 2025</p>
	</div>
</body>
</html>
