<?php
// backend/api/get_menu.php
header('Content-Type: application/json');
require __DIR__.'/db_connect_tocapp.php';

// optional filter by category
$cat = isset($_GET['category'])
     ? trim($_GET['category'])
     : '';

// build query—note your real columns (item_desc, image_name, etc.)
$sql = "SELECT
          item_id,
          item_name,
          item_desc   AS description,
          item_price  AS price,
          item_category AS category,
          CONCAT(item_folder_name, item_image_name) AS image_url
        FROM ap_item_master"
      . ($cat ? " WHERE item_category = :cat" : "");

$stmt = $pdo->prepare($sql);
if ($cat) {
  $stmt->bindValue(':cat', $cat);
}
$stmt->execute();

// return JSON array
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
