<?php
// backend/api/clear_cart.php
session_start();
require_once __DIR__.'/database.php';

// remove from session
$_SESSION['cart'] = [];

// remove from database if logged in
if (!empty($_SESSION['username'])) {
    $db = getDB();
    $uid = $db->prepare('SELECT user_id FROM users WHERE email=?');
    $uid->execute([$_SESSION['username']]);
    if ($u = $uid->fetch(PDO::FETCH_ASSOC)) {
        $del = $db->prepare('DELETE FROM user_carts WHERE user_id = ?');
        $del->execute([$u['user_id']]);
    }
}

// redirect back to cart page
header('Location: /cart.php');
exit;
