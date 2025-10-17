<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<?php
session_start();
// CHANGE IT WITH OUR DATABASE
require_once('database2.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login2.php");
    exit();
}

$db = getDB();
$user_id = $_SESSION['user_id'];

unset($_SESSION['cart']);

$stmt = $db->prepare("SELECT loyalty_points FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$points = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Successful</title>
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
    <h1>🎉 Thank You for Your Order!</h1>
    <p>Your order has been placed successfully.</p>
    <p>You now have <strong><?php echo $points; ?></strong> loyalty point<?php 
        if ($points == 1) { 
            echo ''; 
            } else { 
                echo 's'; 
            }?>!
    </p>
    
    <a href="home2.php">Continue Browsing</a>
</body>
</html>