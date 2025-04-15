<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';

if (isset($_SESSION['username'])) {
  include 'includes/header_user.php';
} else {
  include 'includes/header_guest.php';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Taste of the Carribean</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <p>Hello Home!</p>
    </body>
</html>