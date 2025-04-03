<?php
session_start();
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
    <title>Order Food - Taste of the Caribbean</title>
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

    <h1>Order Your Favorite Caribbean Dish</h1>

    <form action="backend/api/place_order.php" method="post">
        <label for="dish">Select Dish:</label>
        <select name="dish" required>
            <option value="Jerk Chicken">Jerk Chicken - $12</option>
            <option value="Curry Goat">Curry Goat - $15</option>
            <option value="Fried Plantains">Fried Plantains - $5</option>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" min="1" required>

        <button type="submit">Add to Order</button>
    </form>

    <h2>Your Order:</h2>
    <ul>
        <?php
        if (!isset($_SESSION['order'])) {
            $_SESSION['order'] = [];
        }

        foreach ($_SESSION['order'] as $item) {
            echo "<li>{$item['dish']} x {$item['quantity']}</li>";
        }
        ?>
    </ul>

    <a href="payment.php" class="btn">Proceed to Payment</a>
</body>
</html>
