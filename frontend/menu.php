<?php
// frontend/menu.php
session_start();
include __DIR__ . '/scripts/check-services.php';

// ←――― FLASH MESSAGE ―――→
if (!empty($_SESSION['flash_added'])) {
    $added = $_SESSION['flash_added']['name'];
    unset($_SESSION['flash_added']);
    echo <<<HTML
    <div class="alert alert-success flash-added">
      “{$added}” has been added to your cart.
      <a href="/menu.php" class="btn btn-sm btn-outline-primary ml-2">Continue Shopping</a>
      <a href="/cart.php" class="btn btn-sm btn-primary ml-1">View Cart</a>
    </div>
HTML;
}

// load categories
require __DIR__ . '/backend/api/database.php';
$db     = getDB();
$cats   = $db->query('SELECT DISTINCT category FROM menu_items')->fetchAll(PDO::FETCH_COLUMN);

// current filter
$selCat = $_GET['category'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
    <?= $selCat ? htmlspecialchars($selCat).' • ' : '' ?>Menu • Taste of the Caribbean
  </title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Faculty+Glyphic&display=swap">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/menu.css">
  <!-- <link rel="stylesheet" href="css/home.css"> -->
  <!-- <link rel="stylesheet" href="css/global.css"> -->
  <link rel="stylesheet" href="css/footer.css">

</head>
<body>
  <?php
  if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
  } else {
    include __DIR__ . '/includes/header_guest.php';
  } ?>
    <div class="main-content">

      <!-- Category nav -->
      <nav class="category-nav">
        <a href="menu.php" class="<?= $selCat=='' ? 'active' : '' ?>">All</a>
        <?php foreach ($cats as $c): 
          $slug  = urlencode($c);
          $active= $c === $selCat ? 'active':''; ?>
          <a href="menu.php?category=<?= $slug ?>" class="<?= $active ?>">
            <?= htmlspecialchars($c) ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <!-- Menu grid -->
      <div class="container py-5">
        <h1 class="display-4 text-center mb-4">
          <?= $selCat ?: 'All' ?> Menu
        </h1>
        <div id="menu-grid" class="row"></div>
      </div>

      <!-- JS loader -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script>
        $(function(){
          const filter = <?= json_encode($selCat) ?>;
          let url = '/backend/api/get_menu.php' + (filter ? '?category='+encodeURIComponent(filter) : '');
          $.getJSON(url)
            .done(items => {
              const $g = $('#menu-grid').empty();
              if (!items.length) {
                return $g.html('<div class="col-12 text-muted">No items found.</div>');
              }
              items.forEach(i => {
                $g.append(`
                  <div class="col-md-4 mb-4">
                    <a href="item.php?item_id=${i.item_id}" class="text-decoration-none text-dark">
                      <div class="card h-100 shadow-sm">
                        <img src="/images/${i.image_name}"
                            class="card-img-top" alt="${i.item_name}">
                        <div class="card-body">
                          <h5 class="card-title">${i.item_name}</h5>
                          <p class="card-text">${i.description}</p>
                        </div>
                        <div class="card-footer text-right">
                          <strong>$${parseFloat(i.price).toFixed(2)}</strong>
                        </div>
                      </div>
                    </a>
                  </div>`);
              });
            })
            .fail(() => {
              $('#menu-grid').html('<div class="col-12 text-danger">Unable to load menu.</div>');
            });
        });
      </script>
    <div>
      <?php include __DIR__.'/includes/footer.php'; ?>
    </div>  
</body>
</html>
