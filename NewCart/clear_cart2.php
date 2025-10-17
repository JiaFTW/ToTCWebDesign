<?php
session_start();
$_SESSION['cart'] = [];
header("Location: cart2.php");
exit();
?>