<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
// CHANGE IT WITH OUR DATABASE
require_once('database2.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login2.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get total amount from cart2.php
if (isset($_POST['total_amount'])) {
    $total_amount = floatval($_POST['total_amount']);
} else {
    $total_amount = 0.00;
}

// Connect to database
$db = getDB();

// Fetch user loyalty points
$stmt = $db->prepare("SELECT loyalty_points FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $loyalty_points = intval($user['loyalty_points']);
} else {
    $loyalty_points = 0;
}

// Convert points to dollar equivalent (100 points = $1.00)
$max_redeemable_dollars = $loyalty_points / 100.0;

// Don't allow user to redeem more than the total
$max_redeemable_dollars = min($max_redeemable_dollars, $total_amount);
$max_redeemable_points = intval($max_redeemable_dollars * 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="./css/home2.css">
    <link rel="stylesheet" href="./css/cart2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Checkout</h1>
    
    <p>Total Amount: $<?php echo number_format($total_amount, 2); ?></p>
    <p>Your Points: <?php echo $loyalty_points; ?> points (=$<?php echo number_format($loyalty_points / 100, 2); ?>)</p>

    <form action="process_payment2.php" method="post">
        <input type="hidden" name="original_total" value="<?php echo $total_amount; ?>">

        <label>
            <input type="checkbox" name="redeem_points_checkbox" id="redeem_points_checkbox" onchange="toggleRedemption()" />
            Redeem Points
        </label><br>

        <div id="redeem_input_section" style="display: none;">
            <label for="redeem_points_amount">
                Enter points to redeem (Max: <?php echo $max_redeemable_points; ?>):
            </label>
            <input type="number" 
                   name="redeem_points_amount" 
                   id="redeem_points_amount" 
                   min="0" 
                   max="<?php echo $max_redeemable_points; ?>" /><br>
        </div>

        <div id="payment-section">
            <label>Card Number:</label>
            <input type="text" name="card_number" required><br>

            <label>Expiry Date:</label>
            <input type="text" name="expiry_date" required><br>

            <label>CVV:</label>
            <input type="text" name="cvv" required><br>
        </div>

        <button type="submit">Complete Payment</button>
    </form>

    <script>
        function toggleRedemption() {
            const checkbox = document.getElementById('redeem_points_checkbox');
            const redeemInputSection = document.getElementById('redeem_input_section');
            if (checkbox.checked) {
                redeemInputSection.style.display = 'block';
            } else {
                redeemInputSection.style.display = 'none';
            }
        }
    </script>
</body>
</html>