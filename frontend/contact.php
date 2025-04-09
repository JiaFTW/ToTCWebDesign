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
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="./css/contact.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
	<div class="navbar">
		<ul>
			<div class="nav-left">
				<li><img src="images/TOC_Logo.png" alt="taste of the caribbean logo"></li>
				<li><h1>Taste of the Caribbean</h1></li>
			</div>
			<div class="nav-right">
				<li><a href="menu.php">Menu</a></li>
				<li><a href="map.php">Map</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="contact.html">Catering</a></li>
				<li><a href="#about">Hours and Location</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="cart.php"><img src="images/cart_icon.png" alt="Go to cart page"></a></li>
			</div>
		</ul>
	</div>

<h1>Catering</h1>
<p>Let us cater your next big event! Send in a inquiry and we'll get back to you within 1-2 business days.</p>
<div class="container">
	<form id="orderForm">
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label for="firstName" class="required">First Name</label>
					<input type="text" id="firstName" name="firstName" required>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="lastName" class="required">Last Name</label>
					<input type="text" id="lastName" name="lastName" required>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="email" class="required">Email Address</label>
			<input type="email" id="email" name="email" required 
				   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
		</div>
		
		<div class="form-group">
			<label for="phone">Phone Number</label>
			<input type="tel" id="phone" name="phone">
		</div>
		
		<div class="form-group">
			<label for="eventDate">Event Date</label>
			<input type="date" id="eventDate" name="eventDate">
		</div>
		
		<div class="form-group">
			<label for="orderDetails" class="required">Order Details</label>
			<textarea id="orderDetails" name="orderDetails" 
					  placeholder="Please specify what you would like to order and the quantities..." required></textarea>
		</div>
		
		<div class="form-footer">
			<button type="submit" class="btn">Submit Order</button>
			<p class="notification">Fields marked with <span style="color:#e74c3c">*</span> are required</p>
		</div>
	</form>
</div>

</body>
</html>