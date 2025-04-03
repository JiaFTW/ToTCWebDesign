<?php session_start(); ?>
<?php include('./includes/header_guest.php'); ?>

<h2>Login</h2>
<form action="../backend/api/login_user.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>
