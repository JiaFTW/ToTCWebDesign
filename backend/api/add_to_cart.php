<?php
// backend/api/add_to_cart.php
session_start();

// Gather POST data
$item_id  = intval($_POST['item_id'] ?? 0);
$name     = $_POST['name']     ?? '';
$size     = $_POST['size']     ?? 's';
$quantity = intval($_POST['quantity'] ?? 1);
$price    = floatval($_POST['price'] ?? 0);

// Initialize cart if needed
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to session cart
$_SESSION['cart'][] = [
    'item_id'  => $item_id,
    'name'     => $name,
    'size'     => $size,
    'quantity' => $quantity,
    'price'    => $price
];


// Set a flash message for the referring page
$_SESSION['flash_added'] = [
    'name' => $name
  ];

// Redirect back to the referring page (menu or item)
$ref = $_SERVER['HTTP_REFERER'] ?? '/menu.php';
header("Location: $ref");
exit;
