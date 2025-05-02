<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="/css/home.css">
	<link rel="stylesheet" href="css/navbar.css">
	<!-- <link rel="stylesheet" href="css/styles.css"> -->
	<link rel="stylesheet" href="css/map.css">
	<!-- <link rel="stylesheet" href="css/global.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/footer.css">

  </head>
  <body>
	<?php
	if (isset($_SESSION['username'])) {
		include __DIR__.'/includes/header_user.php';
	} else {
		include __DIR__.'/includes/header_guest.php';
	}
	?>
  	<div class="wrapper">
		<div class="main-content">
			 <!-- ── 1. INTERACTIVE MAP ─ -->
			 <section class="map-section index-map">
				<h2>Interactive Food Map</h2>
				<p class="map-sub">Hover over a country to see its signature dish.<br>
					Click for details!</p>

				<!-- same <img usemap> and <map><area> block from map.php → -->
				<div class="map-container">
            <img src="images/map.png" alt="Caribbean Map" usemap="#caribbeanMap" width="1596" height="924" />

            <map name="caribbeanMap">
                <area shape="circle" coords="589,345,44" alt="Explore Cuban Cuisine" href="item.php?item_id=4" onmouseover="showCountryImage(event, 'cuba', 589, 345)" onmouseout="hideCountryImage('cuba')" id="cubaArea" />
                <area shape="circle" coords="540,477,44" alt="Explore Jamaican Cuisine" href="item.php?item_id=7" onmouseover="showCountryImage(event, 'jamaica', 540, 477)" onmouseout="hideCountryImage('jamaica')" id="jamaicaArea" />
                <area shape="circle" coords="790,408,44" alt="Explore Haitian Cuisine" href="item.php?item_id=6" onmouseover="showCountryImage(event, 'haiti', 790, 408)" onmouseout="hideCountryImage('haiti')" id="haitiArea" />
                <area shape="circle" coords="926,450,44" alt="Explore Dominican Cuisine" href="item.php?item_id=5" onmouseover="showCountryImage(event, 'dominican', 926, 450)" onmouseout="hideCountryImage('dominican')" id="dominicanArea" />
                <area shape="circle" coords="1110,477,44" alt="Explore Puerto Rican Cuisine" href="item.php?item_id=8" onmouseover="showCountryImage(event, 'puerto', 1110, 477)" onmouseout="hideCountryImage('puerto')" id="puertoArea" />
                <area shape="circle" coords="35,680,44" alt="Explore Honduran Cuisine" href="item.php?item_id=11" onmouseover="showCountryImage(event, 'honduras', 35, 680)" onmouseout="hideCountryImage('honduras')" id="hondurasArea" />
                <area shape="circle" coords="189,827,44" alt="Explore Nicaraguan Cuisine" href="item.php?item_id=12" onmouseover="showCountryImage(event, 'nicaragua', 189, 827)" onmouseout="hideCountryImage('nicaragua')" id="nicaraguaArea" />
                <area shape="circle" coords="515,148,44" alt="Explore Bahamian Cuisine" href="item.php?item_id=10" onmouseover="showCountryImage(event, 'bahamas', 189, 827)" onmouseout="hideCountryImage('bahamas')" id="bahamasArea" />
            </map>
        </div>

        <!-- Country Popups -->
        <a href="item.php?item_id=4" id="cubaLink" class="countryLink">
            <img id="cubaImage" class="countryImage" src="images/cuba.png" alt="Cuba Highlight" />
        </a>

        <a href="item.php?item_id=13" id="jamaicaLink" class="countryLink">
            <img id="jamaicaImage" class="countryImage" src="images/jamaica.png" alt="Jamaica Highlight" />
        </a>

        <a href="item.php?item_id=6" id="haitiLink" class="countryLink">
            <img id="haitiImage" class="countryImage" src="images/ackee_saltfish.png" alt="Haiti Highlight" />
        </a>

                <a href="item.php?item_id=5" id="dominicanLink" class="countryLink">
                    <img id="dominicanImage" class="countryImage" src="images/dominican.png" alt="Dominican Republic Highlight" />
                </a>

        <a href="item.php?item_id=8" id="puertoLink" class="countryLink">
            <img id="puertoImage" class="countryImage" src="images/puerto.jpg" alt="Puerto Rico Highlight" />
        </a>

        <a href="item.php?item_id=11" id="hondurasLink" class="countryLink">
            <img id="hondurasImage" class="countryImage" src="images/coconut_rice.png" alt="Honduras Highlight" />
        </a>

        <a href="item.php?item_id=12" id="nicaraguaLink" class="countryLink">
            <img id="nicaraguaImage" class="countryImage" src="images/fish_tacos.png" alt="Nicaragua Highlight" />
        </a>

        <a href="item.php?item_id=10" id="bahamasLink" class="countryLink">
            <img id="bahamasImage" class="countryImage" src="images/mango.png" alt="Bahamas Highlight" />
        </a>
    </section>

			<div class="hero">
			<div class="hero-content">
				<img src="images/caribbean-food.jpg" alt="a display of caribbean food on a table near a beach during a sunset">
				<div class="hero-text">
				<h1>Welcome to the Taste of the Caribbean !</h1>
				<p>Welcome to our vibrant Caribbean restaurant! Get ready to try delicious
				flavors, tropical vibes, and unforgettable dining experiences in paradise.</p>
				<button class="learn-more"><a href="about.php">Learn More About Us Here</a></button>
				</div>
			</div>
			</div>

			<div class="order">
				<div class="order-text">
					<h1>Feeling Hungry?</h1>
					<p>Delight in the bold flavors, fresh aromas, and joyful spirit of the Caribbean with every meal at Taste of the Caribbean.
					View our menu and order now!</p>
					<a href="menu.php"><button class="menu">Our Menu</button></a>
				</div>
					<img src="images/Chicken.png" alt="pot of cooked chicken and potatoes">
			</div>

			<div class="address">
				<img src="images/location.jpg" alt="picture of caribbean food on plates on a table">
				<div class="address-text">
					<h1>Want to Dine In?</h1>
					<p>Check <a href="#">here</a> for our hours and location! We will be happy to see and serve up delicious meals that will keep you coming back!</p>
					<a href="contact.php"><button class="contact">Contact Us</button></a>

				</div>
			</div>
		</div>
		<div>
			<?php include __DIR__.'/includes/footer.php'; ?>
		</div>  
	</div>
	<script src="https://cdn.jsdelivr.net/npm/image-map-resizer@1.0.10/js/imageMapResizer.min.js"></script>
	<script src="scripts/map.js"></script>

</body>
</html>