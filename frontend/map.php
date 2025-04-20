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
    <title>Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/navbar.css">

    <link rel="stylesheet" href="css/styles.css"><link rel="stylesheet" href="css/map.css">
</head>
<body>
    <!-- Navigation Bar
    <nav>
        <ul>
            <li><a href="#">Menu</a></li>
            <li><a href="map.html">Map</a></li>
            <li><a href="order.html">Order</a></li>
            <li><a href="profile.html">Profile</a></li>
            <li><a href="index1.html">Login</a></li>
        </ul>
    </nav> -->

    <!-- Hero Section -->
    <header class="hero">
        <h1>Welcome to Taste of the Caribbean</h1>
        <p>Explore authentic Caribbean dishes and flavors.</p>
        <a href="menu.html" class="btn">View Menu</a>
    </header>

    <!-- Map Section -->
    <section class="map-section">
        <h2>Find Your Favorite Caribbean Dish</h2>
        <img src="images/map.jpg" alt="Caribbean Map" usemap="#test" width="1596" height="924">

        <map name="test">
            <!-- Href is field to change where the part of the map links to -->
            <area shape="circle" coords="589,345,44" alt="Cuba" href="category/breakfast.php" onmouseover="showCountryImage(event, 'cuba', 589, 345)" onmouseout="hideCountryImage('cuba')" id="cubaArea">
            <area shape="circle" coords="540,477,44" alt="Jamaica" href="category/carribeanlunchbox.php" onmouseover="showCountryImage(event, 'jamaica', 540, 477)" onmouseout="hideCountryImage('jamaica')" id="jamaicaArea">
            <area shape="circle" coords="790,408,44" alt="Haiti" href="category/dessert.php" onmouseover="showCountryImage(event, 'haiti', 790, 408)" onmouseout="hideCountryImage('haiti')" id="haitiArea">
            <area shape="circle" coords="926,450,44" alt="DominicanR" href="category/saladsbowls.php" onmouseover="showCountryImage(event, 'dominican', 926, 450)" onmouseout="hideCountryImage('dominican')" id="dominicanArea">
            <area shape="circle" coords="1110,477,44" alt="PuertoR" href="category/soups.php" onmouseover="showCountryImage(event, 'puerto', 1110, 477)" onmouseout="hideCountryImage('puerto')" id="puertoArea">
        </map>

        <!-- Country Images and Texts -->
        <img id="cubaImage" class="countryImage" src="images/cuba.jpg" alt="Cuba">
        <div id="cubaText" class="countryText">Test Cuba</div>

        <img id="jamaicaImage" class="countryImage" src="images/jamaica.jpg" alt="Jamaica">
        <div id="jamaicaText" class="countryText">Test Jamaica</div>

        <img id="haitiImage" class="countryImage" src="images/haiti.jpg" alt="Haiti">
        <div id="haitiText" class="countryText">Test Haiti</div>

        <img id="dominicanImage" class="countryImage" src="images/dominican.jpg" alt="Dominican Republic">
        <div id="dominicanText" class="countryText">Test Dominican Republic</div>

        <img id="puertoImage" class="countryImage" src="images/puerto.jpg" alt="Puerto Rico">
        <div id="puertoText" class="countryText">Test Puerto Rico</div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Taste of the Caribbean. All Rights Reserved.</p>
    </footer>

    <script src="scripts/map.js"></script>
</body>
</html>