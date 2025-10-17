<?php
// backend/api/add_to_cart.php
session_start();

//  Pull item data from POST
$item_id  = intval($_POST['item_id']  ?? 0);
$name     = $_POST['name']           ?? '';
$size     = $_POST['size']           ?? 's';
$quantity = intval($_POST['quantity']?? 1);
$price    = floatval($_POST['price'] ?? 0);

//  Initialise session cart if first time ───
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Push the line-item into the cart array 
$_SESSION['cart'][] = [
    'item_id'  => $item_id,
    'name'     => $name,
    'size'     => $size,
    'quantity' => $quantity,
    'price'    => $price
];

// Persist cart for logged-in users 
if (!empty($_SESSION['username'])) {
    require_once __DIR__ . '/database.php';
    $db = getDB();                              // PDO instance

    // Fetch user_id
    $u  = $db->prepare('SELECT user_id FROM users WHERE email = ?');
    $u->execute([ $_SESSION['username'] ]);
    if ($row = $u->fetch(PDO::FETCH_ASSOC)) {
        $uid      = $row['user_id'];
        $cartJson = json_encode($_SESSION['cart']);

        //  Up-sert into user_carts
        $up = $db->prepare("
          INSERT INTO user_carts (user_id, cart)
          VALUES (:uid, :cart)
          ON DUPLICATE KEY UPDATE cart = VALUES(cart)
        ");
        $up->execute([
            ':uid'  => $uid,
            ':cart' => $cartJson
        ]);
    }
}

// Flash message so menu page can show “added” toast 
$_SESSION['flash_added'] = [ 'name' => $name ];

// Redirect user back to where they came from
$referrer = $_SERVER['HTTP_REFERER'] ?? '/menu.php';
header('Location: ' . $referrer);
exit;
