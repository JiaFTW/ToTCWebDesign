<?php
session_start();
include __DIR__ . '/scripts/check-services.php';

if (!empty($_SESSION['flash_added'])) {
    $added = $_SESSION['flash_added']['name'];
    unset($_SESSION['flash_added']);
    echo <<<HTML
    <div class="alert alert-success flash-added">
      “{$added}” has been added to your cart.
      <a href="/merch.php" class="btn btn-sm btn-outline-primary ml-2">Continue Shopping</a>
      <a href="/cart.php" class="btn btn-sm btn-primary ml-1">View Cart</a>
    </div>
HTML;
}

require __DIR__ . '/backend/api/database.php';
$db = getDB();

$stmt = $db->query(
  'SELECT id, item_name, description, price, image_name
   FROM merch_items
   ORDER BY id ASC'
);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Merch • Taste of the Caribbean</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Faculty+Glyphic&display=swap">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/gstyles.css">
</head>

<body>
  <?php
  if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
  } else {
    include __DIR__ . '/includes/header_guest.php';
  } ?>
    
  <div class="main-content">

    <div class="container py-5">
      <h1 class="display-4 text-center mb-4">
        Merch
      </h1>
      <div id="menu-grid" class="row">
        <?php if ($items): ?>
          <?php foreach ($items as $i): ?>
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm">
                <?php if (!empty($i['image_name'])): ?>
                  <img src="/images/<?= htmlspecialchars($i['image_name']) ?>"
                       class="card-img-top"
                       alt="<?= htmlspecialchars($i['item_name']) ?>">
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($i['item_name']) ?></h5>
                  <p class="card-text"><?= htmlspecialchars($i['description']) ?></p>
                </div>
                <div class="card-footer text-right">
                  <strong>$<?= number_format((float)$i['price'], 2) ?></strong>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-muted">No items found.</div>
        <?php endif; ?>
      </div>
    </div>

  </div>

<?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
