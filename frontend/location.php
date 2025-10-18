<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean - Location</title>
    <!-- <link rel="stylesheet" href="/css/home.css"> -->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/location.css">
    <link rel="stylesheet" href="css/footer.css">
    <!-- <link rel="stylesheet" href="css/global.css"> -->

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
      <div class="location-container">
        <div class="location-info">
          <h1>Location and Hours</h1>
          <div class="address-section">
            <h2>Our Address</h2>
            <p>4 Branford Pl, Newark, NJ 07102</p>
          </div>
          <div class="hours-section">
            <h2>Business Hours</h2>
            <div class="hours-grid">
              <div class="day">Monday - Friday</div>
              <div class="time">11:30 am - 8 pm</div>
              <div class="day">Saturday</div>
              <div class="time">9 am - 9 pm</div>
              <div class="day">Sunday</div>
              <div class="time">Closed</div>
            </div>
          </div>
          <a href="https://www.google.com/maps/dir//4+Branford+Pl,+Newark,+NJ+07102" target="_blank" class="directions-btn">Get Directions</a>
        </div>
        <div class="map-container">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.123456789012!2d-74.12345678901234!3d40.12345678901234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c3a1234567890%3A0x1234567890abcdef!2s4%20Branford%20Pl%2C%20Newark%2C%20NJ%2007102!5e0!3m2!1sen!2sus!4v1234567890!5m2!1sen!2sus" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
    <div>
      <?php include __DIR__.'/includes/footer.php'; ?>
    </div>
  </body>
</html>