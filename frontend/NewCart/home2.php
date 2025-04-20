<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
// CHANGE IT WITH OUR DATABASE
require_once('database2.php');

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

$username = null;
$loyalty_points = 0;

if ($user_id) {
    // Get user info (username and loyalty points)
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT username, loyalty_points FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $username = $user['username'];
            $loyalty_points = intval($user['loyalty_points']);
        }
    } catch (PDOException $e) {
        die("DB error: " . $e->getMessage());
    }
}

/* QUERY CREATED LOCALLY TO MAKE THIS WORK

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,  
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

VALUES INSERTED INTO users:

INSERT INTO users (username, password_hash, email)
VALUES	('john123', 'smith456', 'johnsmith@gmail.com'),
		('sarah890', 'park321', 'sarahpark@gmail.com');
*/

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="./css/home2.css">
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

				<li><a href="map.html">Map</a></li>
				<li><a href="login2.php">Login</a></li>
				<li><a href="#contact">Catering</a></li>
				<li><a href="#about">Hours and Location</a></li>
				<li><a href="#about">About</a></li>
				<?php if ($user_id): ?>
                    <li><a href="profile.php">Hi, <?php echo htmlspecialchars($username); ?>!</a></li>
                    <li><a href="cart2.php">Rewards: <?php echo $loyalty_points; ?> pts</a></li>
                    <li><a href="logout2.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login2.php">Login</a></li>
                <?php endif; ?>
				<li><a href="cart2.php"><img src="images/cart_icon.png" alt="Go to cart page"></a></li>
			</div>
		</ul>
	</div>
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
	<div class="order">
		<div class="order-text">
			<h1>Feeling Hungry?</h1>
			<p>Delight in the bold flavors, fresh aromas, and joyful spirit of the Caribbean with every meal at Taste of the Caribbean.
			View our menu and order now!</p>
			<a href="#"><button class="menu">Our Menu</button></a>
		</div>
			<img src="images/Chicken.png" alt="pot of cooked chicken and potatoes">
	</div>
	<div class="address">
		<img src="images/location.jpg" alt="picture of caribbean food on plates on a table">
		<div class="address-text">
			<h1>Want to Dine In?</h1>
			<p>Check <a href="#">here</a> for our hours and location! We will be happy to see and serve up delicious meals that will keep you coming back!</p>
		</div>
	</div>
	<div class="map">
		<div class="map-text">
			<h1>Interactive Food Map</h1>
			<p>Hover over the map to see the most popular dish in that Caribbean country!</p>
		</div>
		<img src="images/placehold_map.png" alt="vector map of the caribbean">
	</div>
	<div class="footer">
		<p> &copy; Taste of the Caribbean 2025</p>
	</div>
</body>
</html>