<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>About • Taste of the Caribbean</title>

    <!-- Single unified stylesheet -->
    <link rel="stylesheet" href="css/gstyles.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  </head>
  <body>
    <?php
      // Check critical services FIRST
      include __DIR__ . '/scripts/check-services.php';

      if (isset($_SESSION['username'])) {
          include __DIR__ . '/includes/header_user.php';
      } else {
          include __DIR__ . '/includes/header_guest.php';
      }
    ?>

    <main>
      <section class="hero">
        <div class="hero-content">
          <!-- Image on the left (inherits .hero img styles from gstyles.css) -->
          <img src="/images/CEO.jpg" alt="Chanice Fish">

          <!-- Text on the right -->
          <div class="hero-text">
            <h1>About Taste of the Caribbean</h1>

            <p>
              I am Chanice Fish, the proud founder of Taste of the Caribbean Restaurant and Catering. Born and raised in Jamaica,
              I launched my first business at the age of 16, driven by a passion to share the rich flavors and vibrant heritage
              of the Caribbean.
            </p>

            <p>
              After facing personal challenges, including the loss of my first store due to family dynamics, I moved to the United
              States to further my education and fulfill my dream of celebrating and reintroducing the Caribbean's rich culinary
              heritage. Taste of the Caribbean is more than just a restaurant; it is a community hub in Newark. We blend modern and
              traditional Caribbean cuisines, offer a unique coffee club with exclusive Caribbean blends, and provide a catering
              service that brings our distinctive flavors to your events.
            </p>

            <p>
              Our journey extends beyond the culinary arts; it's a commitment to community. We're dedicated to nurturing local talent
              through internships and training opportunities for college students, collaborating with local entrepreneurs whose missions
              align with ours, and actively supporting our community.
            </p>

            <p>
              Join us at Taste of the Caribbean, where every meal is a celebration of culture, history, and the enduring spirit of the Caribbean.
              Experience the warmth of our hospitality and the unforgettable flavors that we bring to every plate.
            </p>
          </div>
        </div>
      </section>
    </main>

    <?php include __DIR__.'/includes/footer.php'; ?>
  </body>
</html>
