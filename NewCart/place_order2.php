<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
require_once('database2.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login2.php");
    exit();
}

if (!isset($_SESSION['payment_data'])) {
    die("Missing payment data. Please return to checkout.");
}

$user_id = $_SESSION['user_id'];
$payment_data = $_SESSION['payment_data'];

if (isset($payment_data['original_total'])) {
    $original_total = floatval($payment_data['original_total']);
} else {
    $original_total = 0.0;
}

if (isset($payment_data['redeem_points'])) {
    $redeem_points = intval($payment_data['redeem_points']);
} else {
    $redeem_points = 0;
}

if (isset($payment_data['redeem_dollars'])) {
    $redeem_dollars = floatval($payment_data['redeem_dollars']);
} else {
    $redeem_dollars = 0.0;
}

// Final amount paid by card
$final_paid = $original_total - $redeem_dollars;

// Calculate new loyalty points (only earned on money actually paid)
$loyalty_points_earned = intval(round($final_paid * 100));

try {
    $db = getDB();
    $db->beginTransaction();

    // Deduct redeemed points (if any)
    if ($redeem_points > 0) {
        $stmt = $db->prepare("UPDATE users SET loyalty_points = loyalty_points - :redeemed WHERE user_id = :user_id");
        $stmt->execute([
            ':redeemed' => $redeem_points,
            ':user_id' => $user_id
        ]);
    }

    // Add new earned points
    $stmt = $db->prepare("UPDATE users SET loyalty_points = loyalty_points + :earned WHERE user_id = :user_id");
    $stmt->execute([
        ':earned' => $loyalty_points_earned,
        ':user_id' => $user_id
    ]);

    

    // Clear cart
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    $db->commit();

} catch (PDOException $e) {
    $db->rollBack();
    die("Database error: " . $e->getMessage());
}

// Store order summary in session for success page
$_SESSION['order'][] = [
    'original_total'    => $original_total,
    'redeem_points'     => $redeem_points,
    'redeem_dollars'    => $redeem_dollars,
    'final_paid'        => $final_paid,
    'points_earned'     => $loyalty_points_earned
];

unset($_SESSION['payment_data']); // Clear session payment data after order

header("Location: order_success2.php");
exit();
?>