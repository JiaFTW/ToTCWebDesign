<?php
// logout.php
session_start();

// Show errors in log only
ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    if (!empty($_SESSION['username']) && !empty($_SESSION['cart'])) {
        require __DIR__ . '/backend/api/database.php';
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1) Locate user_id
        $sql  = 'SELECT user_id FROM users WHERE email = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$_SESSION['username']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // 2) Upsert cart JSON
            $cartJson = json_encode($_SESSION['cart']);
            $up = $db->prepare("
              INSERT INTO user_carts (user_id, cart)
              VALUES (:uid, :cart)
              ON DUPLICATE KEY UPDATE cart = VALUES(cart)
            ");
            $up->execute([
                ':uid'  => $row['user_id'],
                ':cart' => $cartJson
            ]);
            error_log("[logout] cart saved for user_id {$row['user_id']}");
        } else {
            error_log("[logout] user not found for email {$_SESSION['username']}");
        }
    } else {
        error_log('[logout] no cart to save or user not set');
    }
} catch (Exception $e) {
    // Log any database/JSON error but continue logout flow
    error_log('[logout] error: ' . $e->getMessage());
}

// Destroy session and redirect
session_unset();
session_destroy();
header('Location: /index.php');
exit;
