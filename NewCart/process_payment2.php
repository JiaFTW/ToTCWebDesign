<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
require_once('database2.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login2.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Connect to database
$db = getDB();

// Fetch user loyalty points
$stmt = $db->prepare("SELECT loyalty_points FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$current_points = intval($user['loyalty_points']);

// Get the original total from the form
if (isset($_POST['original_total'])) {
    $original_total = floatval($_POST['original_total']);
} else {
    $original_total = 0.00;
}

// Initialize redemption values
$redeem_points = 0;
$redeem_dollars = 0.00;

// If the user wants to redeem points
if (isset($_POST['redeem_points_checkbox']) && isset($_POST['redeem_points_amount'])) {
    $input_points = intval($_POST['redeem_points_amount']);

    // Calculate max redeemable points
    $max_redeemable_points = min($current_points, intval($original_total * 100));

    // Validate input
    if ($input_points > $max_redeemable_points) {
        $_SESSION['error'] = "You cannot redeem more than " . $max_redeemable_points . " points.";
        header("Location: checkout2.php");
        exit();
    }

    if ($input_points < 0) {
        $_SESSION['error'] = "Invalid redemption amount.";
        header("Location: checkout2.php");
        exit();
    }

    // Valid input — calculate dollar value
    $redeem_points = $input_points;
    $redeem_dollars = $redeem_points / 100.0;
}

// Simulated payment processing...
// In a real scenario, you would integrate with a payment gateway here

// Save all data to session to pass to place_order2.php
$_SESSION['payment_data'] = [
    'original_total'   => $original_total,
    'redeem_points'    => $redeem_points,
    'redeem_dollars'   => $redeem_dollars,
];

// Redirect to place_order2.php to finalize the order
header("Location: place_order2.php");
exit();
?>