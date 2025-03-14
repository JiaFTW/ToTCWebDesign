<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName = $_POST['name'];
    $itemPrice = $_POST['price'];
    $itemQuantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = [
        'name' => $itemName,
        'price' => (float) $itemPrice,
        'quantity' => (int) $itemQuantity
    ];
    
    header("Location: cart.php"); // Redirect to cart page
    exit();
}
?>