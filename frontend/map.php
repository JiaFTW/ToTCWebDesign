<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Taste of the Caribbean</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/gstyles.css">
  </head>

  <body>
    <?php
    if (isset($_SESSION['username'])) {
      include __DIR__.'/includes/header_user.php';
    } else {
      include __DIR__.'/includes/header_guest.php';
    }
    ?>

    <main class="main">

<!-- Map -->
<section class="map">
        <h2>Find Your Favorite Caribbean Dish</h2>

        <div class="mapbox">
          <img src="images/caribbean-map.png" alt="Caribbean Map" class="mapimg">

          <a href="item.php?item_id=10" class="bahamas">
            <span class="popup">
              <strong>Bahamas</strong>
              <em>Mango Smoothie</em>
              <img src="images/mango.png" alt="Mango Smoothie" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=4" class="cuba">
            <span class="popup">
              <strong>Cuba</strong>
              <em>Cuba Dish</em>
              <img src="images/cuba.png" alt="Cuba Dish" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=13" class="jamaica">
            <span class="popup">
              <strong>Jamaica</strong>
              <em>Ackee & Saltfish</em>
              <img src="images/ackee_saltfish.png" alt="Ackee & Saltfish" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=6" class="haiti">
            <span class="popup">
              <strong>Haiti</strong>
              <em>Haiti Dish</em>
              <img src="images/haiti.png" alt="Haiti Dish" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=5" class="dr">
            <span class="popup">
              <strong>Dominican Republic</strong>
              <em>Dominican Dish</em>
              <img src="images/dominican.png" alt="Dominican Dish" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=8" class="puertorico">
            <span class="popup">
              <strong>Puerto Rico</strong>
              <em>Alcapurrias</em>
              <img src="images/puerto.jpg" alt="Alcapurrias" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=11" class="honduras">
            <span class="popup">
              <strong>Honduras</strong>
              <em>Coconut Rice</em>
              <img src="images/coconut_rice.png" alt="Coconut Rice" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=12" class="nicaragua">
            <span class="popup">
              <strong>Nicaragua</strong>
              <em>Fish Tacos</em>
              <img src="images/fish_tacos.png" alt="Fish Tacos" class="popimg">
            </span>
          </a>
        </div>
      </section>


    </main>

  </body>
   <?php include __DIR__.'/includes/footer.php'; ?>
</html>
