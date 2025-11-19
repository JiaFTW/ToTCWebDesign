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
      <!-- Hero -->
<section class="hero">
  <div class="hero-content">
    <img src="images/caribbean-food.png" alt="A display of Caribbean food on a table near a beach during a sunset">
    <div class="hero-text">
      <h1>Welcome to the Taste of the Caribbean!</h1>
      <p>
        Welcome to our vibrant Caribbean restaurant! Get ready to try delicious
        flavors, tropical vibes, and unforgettable dining experiences in paradise.
      </p>
      <a class="btn" href="about.php">Learn More About Us Here</a>
    </div>
  </div>
</section>

<!-- Map -->
<section class="map">
        <h2>Interactive Food Map</h2>
        <h4>Hover over a country to see its signature dish.</h4>
        <h4>Click for more details!</h4>

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

          <a href="item.php?item_id=125" class="guyana">
            <span class="popup">
              <strong>Guyana</strong>
              <em>Pepper Pot</em>
              <img src="images/pepper-pot.jpg" alt="Pepper Pot" class="popimg">
            </span>
          </a>

          <a href="item.php?item_id=126" class="trinidadtobago">
            <span class="popup">
              <strong>Trinidad and Tobago</strong>
              <em>Doubles</em>
              <img src="images/doubles.jpg" alt="Doubles" class="popimg">
            </span>
          </a>
        </div>
      </section>

<!-- Order -->
<section class="order">
  <div class="order-content">
    <div class="order-text">
      <h2>Feeling Hungry?</h2>
      <p>
        Delight in the bold flavors, fresh aromas, and joyful spirit of the Caribbean with every meal at Taste of the Caribbean.
        View our menu and order now!
      </p>
      <a class="btn" href="menu.php">Our Menu</a>
    </div>
    <img src="images/Chicken.png" alt="Pot of cooked chicken and potatoes">
  </div>
</section>

<!-- Location -->
<section class="address">
  <div class="address-content">
    <img src="images/location.png" alt="Caribbean food on plates on a table">
    <div class="address-text">
      <h2>Want to Dine In?</h2>
      <p>
        Check <a href="location.php">here</a> for our hours and location! We will be happy to see you
        and serve up delicious meals that will keep you coming back!
      </p>
      <a class="btn" href="location.php">Location and Hours</a>
    </div>
  </div>
</section>

    </main>

  </body>
   <?php include __DIR__.'/includes/footer.php'; ?>
</html>
