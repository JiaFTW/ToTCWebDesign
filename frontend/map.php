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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/map.css" />
    <link rel="stylesheet" href="css/navbar.css" />
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
        <div class="map-container">
            <img src="images/map.png" alt="Caribbean Map" usemap="#caribbeanMap" width="1596" height="924" />

            <map name="caribbeanMap">
                <area shape="circle" coords="589,345,44" alt="Explore Cuban Cuisine" href="item.php?item_id=4" onmouseover="showCountryImage(event, 'cuba', 589, 345)" onmouseout="hideCountryImage('cuba')" id="cubaArea" />
                <area shape="circle" coords="540,477,44" alt="Explore Jamaican Cuisine" href="item.php?item_id=7" onmouseover="showCountryImage(event, 'jamaica', 540, 477)" onmouseout="hideCountryImage('jamaica')" id="jamaicaArea" />
                <area shape="circle" coords="790,408,44" alt="Explore Haitian Cuisine" href="item.php?item_id=6" onmouseover="showCountryImage(event, 'haiti', 790, 408)" onmouseout="hideCountryImage('haiti')" id="haitiArea" />
                <area shape="circle" coords="926,450,44" alt="Explore Dominican Cuisine" href="item.php?item_id=5" onmouseover="showCountryImage(event, 'dominican', 926, 450)" onmouseout="hideCountryImage('dominican')" id="dominicanArea" />
                <area shape="circle" coords="1110,477,44" alt="Explore Puerto Rican Cuisine" href="item.php?item_id=8" onmouseover="showCountryImage(event, 'puerto', 1110, 477)" onmouseout="hideCountryImage('puerto')" id="puertoArea" />
                <area shape="circle" coords="35,680,44" alt="Explore Honduran Cuisine" href="item.php?item_id=1" onmouseover="showCountryImage(event, 'honduras', 35, 680)" onmouseout="hideCountryImage('honduras')" id="hondurasArea" />
                <area shape="circle" coords="189,827,44" alt="Explore Nicaraguan Cuisine" href="item.php?item_id=2" onmouseover="showCountryImage(event, 'nicaragua', 189, 827)" onmouseout="hideCountryImage('nicaragua')" id="nicaraguaArea" />
                <area shape="circle" coords="515,148,44" alt="Explore Bahamian Cuisine" href="item.php?item_id=3" onmouseover="showCountryImage(event, 'bahamas', 189, 827)" onmouseout="hideCountryImage('bahamas')" id="bahamasArea" />
            </map>
        </div>

        <!-- Country Popups -->
        <a href="item.php?item_id=4" id="cubaLink" class="countryLink">
            <img id="cubaImage" class="countryImage" src="images/cuba.png" alt="Cuba Highlight" />
        </a>

        <a href="item.php?item_id=7" id="jamaicaLink" class="countryLink">
            <img id="jamaicaImage" class="countryImage" src="images/jamaica.png" alt="Jamaica Highlight" />
        </a>

        <a href="item.php?item_id=6" id="haitiLink" class="countryLink">
            <img id="haitiImage" class="countryImage" src="images/haiti.png" alt="Haiti Highlight" />
        </a>

        <a href="item.php?item_id=5" id="dominicanLink" class="countryLink">
            <img id="dominicanImage" class="countryImage" src="images/dominican.png" alt="Dominican Republic Highlight" />
        </a>

        <a href="item.php?item_id=8" id="puertoLink" class="countryLink">
            <img id="puertoImage" class="countryImage" src="images/puerto.png" alt="Puerto Rico Highlight" />
        </a>

        <a href="item.php?item_id=1" id="hondurasLink" class="countryLink">
            <img id="hondurasImage" class="countryImage" src="images/honduras.png" alt="Honduras Highlight" />
        </a>

        <a href="item.php?item_id=2" id="nicaraguaLink" class="countryLink">
            <img id="nicaraguaImage" class="countryImage" src="images/nicaragua.png" alt="Nicaragua Highlight" />
        </a>

        <a href="item.php?item_id=3" id="bahamasLink" class="countryLink">
            <img id="bahamasImage" class="countryImage" src="images/bahamas.png" alt="Bahamas Highlight" />
        </a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Taste of the Caribbean. All Rights Reserved.</p>
    </footer>

    <script src="scripts/map.js"></script>
</body>
</html>