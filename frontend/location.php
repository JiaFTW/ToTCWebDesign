<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Taste of the Caribbean Restaurant & Catering - Location</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Site styles -->
  <link rel="stylesheet" href="css/gstyles.css">
</head>
<body>
  <?php
    // Check critical services BEFORE rendering
    include __DIR__ . '/scripts/check-services.php';

    if (isset($_SESSION['username'])) {
      include __DIR__ . '/includes/header_user.php';
    } else {
      include __DIR__ . '/includes/header_guest.php';
    }
  ?>

  <main>
    <div class="location-container">

      
      <section class="location-header">
        <h1>Location & Hours</h1>
      </section>

      
      <section class="location-grid">

      
        <div class="loc-card hours-box">
          <header>Hours</header>
          <table>
            <tbody>
              <tr class="today"><td>Monday</td><td>11:30 AM – 8:00 PM</td></tr>
              <tr><td>Tuesday</td><td>11:30 AM – 8:00 PM</td></tr>
              <tr><td>Wednesday</td><td>11:30 AM – 8:00 PM</td></tr>
              <tr><td>Thursday</td><td>11:30 AM – 8:00 PM</td></tr>
              <tr><td>Friday</td><td>11:30 AM – 8:00 PM</td></tr>
              <tr><td>Saturday</td><td>9:00 AM – 9:00 PM</td></tr>
              <tr><td>Sunday</td><td>Closed</td></tr>
            </tbody>
          </table>
        </div>

        <!-- ADDRESS + BUTTON -->
        <div class="loc-card address-box">
          <header>Address</header>
          <div class="content">
            <p>
              <strong>Taste of the Caribbean</strong><br>
              4 Branford Pl, Newark, NJ 07102
            </p>
            <p><strong>Phone:</strong> (555) 123-4567</p>
            <p>Parking Available</p>

            <a class="btn"
               href="https://www.google.com/maps/dir/?api=1&destination=4+Branford+Pl,+Newark,+NJ+07102"
               target="_blank" rel="noopener">
              Get Directions
            </a>
          </div>
        </div>

        <!-- MAP -->
        <div class="loc-card">
          <header>Map</header>
          <div class="map-box">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.123456789012!2d-74.12345678901234!3d40.12345678901234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c3a1234567890%3A0x1234567890abcdef!2s4%20Branford%20Pl%2C%20Newark%2C%20NJ%2007102!5e0!3m2!1sen!2sus!4v1234567890!5m2!1sen!2sus"
              loading="lazy" allowfullscreen
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

      </section>
    </div>
  </main>

  <?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
