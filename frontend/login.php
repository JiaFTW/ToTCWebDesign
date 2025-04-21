<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';

if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="/css/navbar.css">
</head>
<body>
    <h2>Login</h2>
    <form action="../backend/api/login_user.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>

