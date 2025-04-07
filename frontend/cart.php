<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'includes/header_user.php';
  } else {
    include 'includes/header_guest.php';
  }

// Sample cart structure (this should come from session)
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="./css/home2.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
	<!-- <div class="navbar">
		<ul>
			<div class="nav-left">
				<li><img src="images/TOC_Logo.png" /></li>
				<li><a href="#home"><h1>Taste of the Caribbean<h1></a></li>
			</div>
			<div class="nav-right">
                <li><a href="map.html">Map</a></li>
				<li><a href="index1.html">Login</a></li>
				<li><a href="#contact">Catering</a></li>
				<li><a href="#about">Hours and Location</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="cart.php"><img src="images/cart_icon.png" alt="Go to cart page"></a></li>
			</div>
		</ul>
	</div> -->
  <h2>Your Cart</h2>
    <div class="cart-container">
        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a class="a" href="menu.html">Browse our menu</a> to add delicious items!</p>
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
            <div class="cart-summary">
                <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
                <p>Tax: $<?php echo number_format($subtotal * 0.08, 2); ?></p>
                <p><strong>Total: $<?php echo number_format($subtotal * 1.08, 2); ?></strong></p>
                <button class="checkout-btn">Proceed to Checkout</button>
            </div>
        <?php endif; ?>
        <form action="backend/api/clear_cart.php" method="POST">
            <button type="submit">Clear Cart</button>
        </form>
    </div>

    <div class="footerc">
        <p>&copy; Taste of the Caribbean 2025</p>
    </div>
</body>
</html>