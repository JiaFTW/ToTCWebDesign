<?php
/**
 * cart_sync.php
 * If logged-in and session cart is empty OR caller requests a refresh,
 * load the latest cart JSON from user_carts into $_SESSION['cart'].
 */

function refreshCart(bool $force = false): void {
    if (empty($_SESSION['username'])) return;

    // only hit DB if cart not set OR caller forces refresh
    if (!$force && !empty($_SESSION['cart'])) return;

    require_once __DIR__ . '/database.php';
    $db = getDB();

    $stmt = $db->prepare("
        SELECT uc.cart
        FROM user_carts uc
        JOIN users u ON u.user_id = uc.user_id
        WHERE u.email = ?
    ");
    $stmt->execute([$_SESSION['username']]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['cart'] = json_decode($row['cart'], true) ?: [];
    } else {
        $_SESSION['cart'] = [];
    }
}

// clear cart from DB after checkout
// (already saved in DB by order_consumer)
// (this is a separate function to avoid circular dependency)
// (order_consumer requires cart_sync, which requires database)
function clearCartStorage() {
    if (!isset($_SESSION['username'])) return;
    $db = getDB();
    $db->prepare(
        "DELETE FROM user_carts
          WHERE user_id = (SELECT user_id FROM users WHERE email = ?)"
    )->execute([$_SESSION['username']]);
}