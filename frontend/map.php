<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/styles.css"><link rel="stylesheet" href="css/map.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">

</head>
<body>
    <!-- Hero Section -->
    <header class="hero">
        <h1>Welcome to Taste of the Caribbean</h1>
        <p>Explore authentic Caribbean dishes and flavors.</p>
        <a href="menu.php" class="btn">View Menu</a>
    </header>

    <!-- Map Section -->
    <section class="map-section">
        <h2>Find Your Favorite Caribbean Dish</h2>
        <img src="images/map.png" alt="Caribbean Map" usemap="#test" width="1596" height="924">

        <map name="test">
            <!-- Href is field to change where the part of the map links to -->
            <area shape="circle" coords="589,345,44" alt="Cuba" href="item.php?item_id=4" onmouseover="showCountryImage(event, 'cuba', 589, 345)" onmouseout="hideCountryImage('cuba')" id="cubaArea">
            <area shape="circle" coords="540,477,44" alt="Jamaica" href="item.php?item_id=7" onmouseover="showCountryImage(event, 'jamaica', 540, 477)" onmouseout="hideCountryImage('jamaica')" id="jamaicaArea">
            <area shape="circle" coords="790,408,44" alt="Haiti" href="item.php?item_id=6" onmouseover="showCountryImage(event, 'haiti', 790, 408)" onmouseout="hideCountryImage('haiti')" id="haitiArea">
            <area shape="circle" coords="926,450,44" alt="DominicanR" href="item.php?item_id=5" onmouseover="showCountryImage(event, 'dominican', 926, 450)" onmouseout="hideCountryImage('dominican')" id="dominicanArea">
            <area shape="circle" coords="1110,477,44" alt="PuertoR" href="item.php?item_id=8" onmouseover="showCountryImage(event, 'puerto', 1110, 477)" onmouseout="hideCountryImage('puerto')" id="puertoArea">
            <area shape="circle" coords="1110,477,44" alt="Hounduras" href="item.php?item_id=8" onmouseover="showCountryImage(event, 'hounduras', 35, 680)" onmouseout="hideCountryImage('hounduras')" id="houndurasArea">
            <area shape="circle" coords="1110,477,44" alt="Nicaragua" href="item.php?item_id=8" onmouseover="showCountryImage(event, 'nicaragua', 1110, 477)" onmouseout="hideCountryImage('nicaragua')" id="nicaraguaArea">
        </map>

        <!-- Country Images and Texts Images and text are currently placeholder unti; the menu is finished -->
        <a href="item.php?item_id=4" id="cubaLink" class="countryLink">
        <img id="cubaImage" class="countryImage" src="images/cuba.png" alt="Cuba">
        </a>

        <a href="item.php?item_id=7" id="jamicaLink" class="countryLink">
        <img id="jamaicaImage" class="countryImage" src="images/jamaica.png" alt="Jamaica">
        </a>

        <a href="item.php?item_id=6" id="haitiLink" class="countryLink">
        <img id="haitiImage" class="countryImage" src="images/haiti.png" alt="Haiti">
        </a>

        <a href="item.php?item_id=5" id="dominicanLink" class="countryLink">
        <img id="dominicanImage" class="countryImage" src="images/dominican.png" alt="Dominican Republic">
        </a>

        <a href="item.php?item_id=8" id="puertoLink" class="countryLink">
        <img id="puertoImage" class="countryImage" src="images/puerto.jpg" alt="Puerto Rico">
        </a>
        
        <a href="item.php?item_id=1" id="hondurasLink" class="countryLink">
        <img id="houndurasImage" class="countryImage" src="images/hounduras.png" alt="Hounduras">
        </a>

        <a href="item.php?item_id=2" id="nicaraguaLink" class="countryLink">
        <img id="nicaraguaImage" class="countryImage" src="images/nicaragua.png" alt="Nicaragua">
        </a>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Taste of the Caribbean. All Rights Reserved.</p>
    </footer>

    <script src="scripts/map.js"></script>
</body>
</html>