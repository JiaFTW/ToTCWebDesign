<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="menu.html">Menu</a></li>
            <li><a href="map.html">Map</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="profile.html">Profile</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <h1>Create an Account</h1>

    <form action="../backend/api/register_user.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>
