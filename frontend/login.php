<?php
// public_html/login.php
session_start();

// Health check
include __DIR__ . '/scripts/check-services.php';

// Grab & clear any flash error
$loginError = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login • Taste of the Caribbean</title>
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/footer.css">
  <!-- fonts… -->
</head>
<body>
  <?php
    if (isset($_SESSION['username'])) {
      include __DIR__.'/includes/header_user.php';
    } else {
      include __DIR__.'/includes/header_guest.php';
    }
  ?>

  <div class="main-content">
    <div class="container">
      <h1>Login</h1>

      <?php if ($loginError): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($loginError)?></div>
      <?php endif; ?>

      <form action="/backend/api/login_user.php" method="POST">
        <div class="form-group">
          <label for="email">Email:</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          >
        </div>

        <div class="form-group">
          <label for="password">Password:</label>
          <input
            type="password"
            id="password"
            name="password"
            required
          >
        </div>

        <button type="submit">Login</button>
      </form>

      <p>
        Don't have an account?
        <a href="register.php">Register here</a>
      </p>
    </div>
  </div>

  <?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
