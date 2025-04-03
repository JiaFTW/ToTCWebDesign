<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName = $_POST['name'];
    $itemPrice = $_POST['price'];
    $itemSize = $_POST['size'];
    $itemQuantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = [
        'name' => $itemName . " (" . strtoupper($itemSize) . ")",
        'price' => (float) $itemPrice,
        'quantity' => (int) $itemQuantity
    ];
    
    header("Location: ../../frontend/cart.php"); // Redirect to cart page
    exit();
}
?>