<?php
session_start();
$_SESSION['cart'] = [];
header("Location:  /../../frontend/cart.php");
exit();
?>