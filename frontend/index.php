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
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="/css/home2.css">
	<link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/wave_divider.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="hero">
      <div class="hero-content">
        <div class="hero-image">
          <img src="images/caribbean-food.jpg" alt="a display of caribbean food on a table near a beach during a sunset">
        </div>
        <div class="hero-text">
          <h1>Welcome to the Taste of the Caribbean Restaurant & Catering!</h1>
          <p>Welcome to our vibrant Caribbean restaurant! Get ready to try delicious
          flavors, tropical vibes, and unforgettable dining experiences in paradise.</p>
          <button class="learn-more"><a href="#">Learn More About Us Here</a></button>
        </div>
      </div>
    </div>

	<div class="wave-divider-blue"></div>

	<div class="order">
		<div class="order-text">
			<h1>Feeling Hungry?</h1>
			<p>Delight in the bold flavors, fresh aromas, and joyful spirit of the Caribbean with every meal at Taste of the Caribbean.
			View our menu and order now!</p>
			<a href="menu.php"><button class="menu">Our Menu</button></a>
		</div>
			<img src="images/Chicken.png" alt="pot of cooked chicken and potatoes">
	</div>

	<div class="wave-divider-white"></div>

	<div class="address">
		<img src="images/location.jpg" alt="picture of caribbean food on plates on a table">
		<div class="address-text">
			<h1>Want to Dine In?</h1>
			<p>Check <a href="#">here</a> for our hours and location! We will be happy to see and serve up delicious meals that will keep you coming back!</p>
		</div>
	</div>

	<div class="wave-divider-curved"></div>

	<div class="map">
		<div class="map-text">
			<h1>Interactive Food Map</h1>
			<a href="map.php"><button>Interactive Map</button></a>
			<p>Hover over the map to see the most popular dish in that Caribbean country!</p>
		</div>
		<img src="images/placehold_map.png" alt="vector map of the caribbean">
	</div>

	<div class="wave-divider-bottom"></div>

	<div class="footer">
		<p> &copy; Taste of the Caribbean 2025</p>
	</div>
</body>
</html>