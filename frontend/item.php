<?php
// frontend/item.php
session_start();
include __DIR__ . '/scripts/check-services.php';

if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}

// ←――― FLASH MESSAGE GOES HERE ―――→
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


$item_id = intval($_GET['item_id'] ?? 0);
require __DIR__ . '/backend/api/database.php';
$db = getDB();
$stmt = $db->prepare(
  'SELECT item_name, description, price, image_name, category
   FROM menu_items WHERE id = :id'
);
$stmt->execute(['id' => $item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
    <?= $item 
        ? htmlspecialchars($item['item_name']) 
        : 'Item Not Found' 
    ?> • Taste of the Caribbean
  </title>
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
  <div class="container py-5">

    <?php if (!$item): ?>
      <div class="alert alert-danger">Item not found.</div>

    <?php else: ?>

      <div class="item-detail">

        <!-- Image Column -->
        <div class="img-col">
          <img 
            src="/images/<?= htmlspecialchars($item['image_name']) ?>"
            alt="<?= htmlspecialchars($item['item_name']) ?>">
        </div>

        <!-- Info Column with “Add to Order” form -->
        <div class="info-col">
          <h2><?= htmlspecialchars($item['item_name']) ?></h2>
          <p class="category">
            <em>Category: <?= htmlspecialchars($item['category']) ?></em>
          </p>
          <p class="description">
            <?= htmlspecialchars($item['description']) ?>
          </p>

          <!-- Live‑updating price -->
          <h4 class="price" id="total-price">
            $<?= number_format($item['price'], 2) ?>
          </h4>

          <!-- Add to Order form -->
          <form 
            action="/backend/api/add_to_cart.php" 
            method="POST" 
            id="add-to-cart"
          >
            <input 
              type="hidden" 
              name="item_id" 
              value="<?= $item_id ?>">
            <input 
              type="hidden" 
              name="name" 
              value="<?= htmlspecialchars($item['item_name']) ?>">
            <input 
              type="hidden" 
              name="price" 
              id="base-price" 
              value="<?= $item['price'] ?>">

            <div class="form-group">
              <label for="size">Size</label>
              <select 
                name="size" 
                id="size" 
                class="form-control w-50"
              >
                <option value="s">Small</option>
                <option value="m">Medium</option>
                <option value="l">Large</option>
              </select>
            </div>

            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input
                type="number"
                name="quantity"
                id="quantity"
                class="form-control w-25"
                value="1"
                min="1">
            </div>

            <button 
              type="submit" 
              class="order-btn"
            >
              Add to Order
            </button>
          </form>

          <!-- Link to view the current order -->
          <a 
            href="cart.php" 
            class="btn btn-outline-secondary mt-3"
          >
            View Order
          </a>
        </div>
      </div>

      <!-- JavaScript: recalculate price on size/quantity change -->
      <script>
      (function() {
        const basePriceInput = document.getElementById('base-price');
        const qtyInput       = document.getElementById('quantity');
        const sizeSelect     = document.getElementById('size');
        const totalLabel     = document.getElementById('total-price');

        const base = parseFloat(basePriceInput.value);

        function recalc() {
          let qty = parseInt(qtyInput.value) || 1;
          let mul = 1;
          if (sizeSelect.value === 'm') mul = 1.2;
          if (sizeSelect.value === 'l') mul = 1.5;

          const single = base * mul;
          const total  = single * qty;

          // Update the display and hidden price field
          totalLabel.textContent = '$' + total.toFixed(2);
          basePriceInput.value   = single.toFixed(2);
        }

        qtyInput.addEventListener('input', recalc);
        sizeSelect.addEventListener('change', recalc);
      })();
      </script>

    <?php endif; ?>
  </div>
</body>
</html>
