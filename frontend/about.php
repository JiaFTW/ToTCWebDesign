<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
    <?php
        // Check critical services FIRST (before anything else that depends on them)
        include __DIR__ . '/scripts/check-services.php';

        if (isset($_SESSION['username'])) {
            include __DIR__ . '/includes/header_user.php';
        } else {
            include __DIR__ . '/includes/header_guest.php';
        }
    ?>  
    <div class="main-content">
    <div class="main-content about-page">
      <div class="hero">
        <div class="hero-content">
          <div class="hero-image">
            <img src="/images/CEO.jpg" alt="Chanice Fish">
          </div>
          <div class="hero-text">
            <h1>About Taste of the Caribbean</h1>
            <p>I am Chanice Fish, the proud founder of Taste of the Caribbean Restaurant and Catering. Born and raised in Jamaica, I launched my first business at the age of 16, driven by a passion to share the rich flavors and vibrant heritage of the Caribbean.</p>
            
            <p>After facing personal challenges, including the loss of my first store due to family dynamics, I moved to the United States to further my education and fulfill my dream of celebrating and reintroducing the Caribbean's rich culinary heritage. Taste of the Caribbean is more than just a restaurant; it is a community hub in Newark. We blend modern and traditional Caribbean cuisines, offer a unique coffee club with exclusive Caribbean blends, and provide a catering service that brings our distinctive flavors to your events.</p>
            
            <p>Our journey extends beyond the culinary arts; it's a commitment to community. We're dedicated to nurturing local talent through internships and training opportunities for college students, collaborating with local entrepreneurs whose missions align with ours, and actively supporting our community.</p>
            
            <p>Join us at Taste of the Caribbean, where every meal is a celebration of culture, history, and the enduring spirit of the Caribbean. Experience the warmth of our hospitality and the unforgettable flavors that we bring to every plate.</p>
          </div>
        </div>
      </div>
    </div>
      </div>
		<div>
			<?php include __DIR__.'/includes/footer.php'; ?>
		</div> 
  </body>
</html>