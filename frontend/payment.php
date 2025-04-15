<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';

if (isset($_SESSION['username'])) {
  include 'includes/header_user.php';
} else {
  include 'includes/header_guest.php';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/navbar.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- <nav>
        <ul>
            <li><a href="menu.html">Menu</a></li>
            <li><a href="map.html">Map</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="profile.html">Profile</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav> -->

    <h1>Enter Your Payment Details</h1>

    <form action="backend/api/process_payment.php" method="post">
        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" required>

        <label for="expiry_date">Expiry Date:</label>
        <input type="text" name="expiry_date" placeholder="MM/YY" required>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" required>

        <button type="submit">Complete Payment</button>
    </form>
</body>
</html>
