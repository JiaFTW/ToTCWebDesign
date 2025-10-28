<?php
// frontend/item.php
session_start();
include __DIR__ . '/scripts/check-services.php';

// flash message
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

  <link rel="stylesheet" href="css/gstyles.css">

  <!-- small, scoped styles -->
  <style>
    /* fixed image */
    .item-detail .img-col .item-img {
      width: 350px;
      height: 350px;
      object-fit: cover;
      border-radius: 12px;
      display: block;
    }

    /* layout */
    .item-detail {
      display: grid;
      grid-template-columns: 1fr 1.2fr;
      gap: 2rem;
      align-items: start;
    }

    /* buttons side by side */
    .actions-row {
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    @media (max-width: 768px) {
      .item-detail {
        grid-template-columns: 1fr;
      }
      .item-detail .img-col .item-img {
        width: 300px;
        height: 300px;
      }
    }
  </style>
</head>
<body>
  <?php
    if (isset($_SESSION['username'])) {
      include __DIR__ . '/includes/header_user.php';
    } else {
      include __DIR__ . '/includes/header_guest.php';
    }
  ?>

  <div class="container py-5">
    <?php if (!$item): ?>
      <div class="alert alert-danger">Item not found.</div>

    <?php else: ?>
      <div class="item-detail">

        <!-- image -->
        <div class="img-col">
          <img
            class="item-img"
            src="/images/<?= htmlspecialchars($item['image_name']) ?>"
            alt="<?= htmlspecialchars($item['item_name']) ?>">
        </div>

        <!-- info and form -->
        <div class="info-col">
          <h2><?= htmlspecialchars($item['item_name']) ?></h2>

          <p class="category">
            <em>Category: <?= htmlspecialchars($item['category']) ?></em>
          </p>

          <p class="description">
            <?= htmlspecialchars($item['description']) ?>
          </p>

          <!-- live price -->
          <h4 class="price" id="total-price">
            $<?= number_format($item['price'], 2) ?>
          </h4>

          <!-- form -->
          <form
            action="/backend/api/add_to_cart.php"
            method="POST"
            id="add-to-cart"
          >
            <input
              type="hidden"
              name="item_id"
              value="<?= $item_id ?>"
            >
            <input
              type="hidden"
              name="name"
              value="<?= htmlspecialchars($item['item_name']) ?>"
            >
            <input
              type="hidden"
              name="price"
              id="base-price"
              value="<?= $item['price'] ?>"
            >

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
                min="1"
              >
            </div>

            <!-- buttons in a row -->
            <div class="actions-row">
              <button
                type="submit"
                class="btn"
              >
                Add to Order
              </button>

              <a
                href="cart.php"
                class="btn btn-outline-secondary"
                role="button"
              >
                View Order
              </a>
            </div>
          </form>
        </div>
      </div>

      <!-- recalc price -->
      <script>
      (function() {
        const basePriceInput = document.getElementById('base-price');
        const qtyInput       = document.getElementById('quantity');
        const sizeSelect     = document.getElementById('size');
        const totalLabel     = document.getElementById('total-price');

        const base = parseFloat(basePriceInput.value);

        function recalc() {
          let qty = parseInt(qtyInput.value, 10) || 1;
          let mul = 1;
          if (sizeSelect.value === 'm') mul = 1.2;
          if (sizeSelect.value === 'l') mul = 1.5;

          const single = base * mul;
          const total  = single * qty;

          totalLabel.textContent = '$' + total.toFixed(2);
          basePriceInput.value   = single.toFixed(2);
        }

        qtyInput.addEventListener('input', recalc);
        sizeSelect.addEventListener('change', recalc);
      })();
      </script>

    <?php endif; ?>
  </div>

  <div>
    <?php include __DIR__.'/includes/footer.php'; ?>
  </div>
</body>
</html>
