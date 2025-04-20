<?php
// backend/api/get_menu.php
header('Content-Type: application/json');
require __DIR__ . '/database.php';

try {
    $db = getDB();

    if (!empty($_GET['item_id'])) {
        $stmt = $db->prepare(
          'SELECT id AS item_id, item_name, description, price, image_name, category 
           FROM menu_items WHERE id = :id'
        );
        $stmt->execute(['id' => $_GET['item_id']]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data ? $data : []);
    }
    else if (!empty($_GET['category'])) {
        $stmt = $db->prepare(
          'SELECT id AS item_id, item_name, description, price, image_name 
           FROM menu_items WHERE category = :cat'
        );
        $stmt->execute(['cat' => $_GET['category']]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    else {
        $stmt = $db->query(
          'SELECT id AS item_id, item_name, description, price, image_name 
           FROM menu_items'
        );
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Could not fetch menu.']);
}
