<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
require_once('database.php');

// Get total amount from cart.php
if (isset($_POST['total_amount'])) {
    $total_amount = floatval($_POST['total_amount']);
} else {
    $total_amount = 0.00;
}

$loyalty_points = 0;
$max_redeemable_points = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $db = getDB();

    // Fetch loyalty points
    $stmt = $db->prepare("SELECT loyalty_points FROM users WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $loyalty_points = intval($user['loyalty_points']);
        $max_redeemable_dollars = min($loyalty_points / 100.0, $total_amount);
        $max_redeemable_points = intval($max_redeemable_dollars * 100);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="./css/home2.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&family=Faculty+Glyphic&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Checkout</h1>
    
    <p>Total Amount: $<?php echo number_format($total_amount, 2); ?></p>

    <form action="process_payment.php" method="post">
        <input type="hidden" name="original_total" value="<?php echo $total_amount; ?>">

        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Your Points: <?php echo $loyalty_points; ?> (=$<?php echo number_format($loyalty_points / 100.0, 2); ?>)</p>

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
        <?php else: ?>
            <p>Enter your card information below to complete your purchase.</p>
        <?php endif; ?>

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