<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
// CHANGE IT WITH OUR DATABASE
require_once('database.php');

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

$username = null;
$loyalty_points = 0;

if ($user_id) {
    // Get user info (username and loyalty points)
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT username, loyalty_points FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $username = $user['username'];
            $loyalty_points = intval($user['loyalty_points']);
        }
    } catch (PDOException $e) {
        die("DB error: " . $e->getMessage());
    }
}

/* QUERY CREATED LOCALLY TO MAKE THIS WORK

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,  
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

VALUES INSERTED INTO users:

INSERT INTO users (username, password_hash, email)
VALUES	('john123', 'smith456', 'johnsmith@gmail.com'),
		('sarah890', 'park321', 'sarahpark@gmail.com');
*/

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="./css/home2.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
	<div class="navbar">
		<ul>
			<div class="nav-left">
				<li><img src="images/TOC_Logo.png" /></li>
				<li><a href="home.php"><h1>Taste of the Caribbean<h1></a></li>
			</div>
			<div class="nav-right">
				<li><a href="menu.php">Menu</a></li>
				<li><a href="map.html">Map</a></li>
				<li><a href="#contact">Catering</a></li>
				<li><a href="#about">Hours and Location</a></li>
				<li><a href="#about">About</a></li>
                <?php if ($user_id): ?>
                    <li><a href="profile.php">Hi, <?php echo htmlspecialchars($username); ?>!</a></li>
                    <li><a href="cart.php">Rewards: <?php echo $loyalty_points; ?> pts</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
                <li><a href="cart.php"><img src="images/cart_icon.png" alt="Go to cart page"></a></li>
			</div>
		</ul>
	</div>
  <h2>Your Cart</h2>
    <div class="cart-container">
        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a class="a" href="menu.php">Browse our menu</a> to add delicious items!</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    foreach ($cart as $item):
                        $total = $item['price'] * $item['quantity'];
                        $subtotal += $total;
                    ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($item['name']); ?>
                            </td>
                            <td>
                                $<?php echo number_format($item['price'], 2); ?>
                            </td>
                            <td>
                                <?php echo $item['quantity']; ?>
                            </td>
                            <td>
                                $<?php echo number_format($total, 2); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php
                $tax = $subtotal * 0.06625;
                $grand_total = $subtotal + $tax;
            ?>

            <div class="cart-summary">
                <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
                <p>Tax: $<?php echo number_format($tax, 2); ?></p>
                <p><strong>Total: $<?php echo number_format($grand_total, 2); ?></strong></p>
                <form method="POST" action="checkout.php">
                    <input type="hidden" name="total_amount" value="<?php echo number_format($grand_total, 2, '.', ''); ?>">
                    <button class="checkout-btn" type="submit">Proceed to Checkout</button>
                </form>
            </div>
        <?php endif; ?>
        <form action="clear_cart.php" method="POST">
            <button type="submit">Clear Cart</button>
        </form>
    </div>

    <div class="footerc">
        <p>&copy; Taste of the Caribbean 2025</p>
    </div>
</body>
</html>