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

  <!-- Single unified stylesheet -->
  <link rel="stylesheet" href="css/gstyles.css">

  <!-- fonts… -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  <?php
    if (isset($_SESSION['username'])) {
      include __DIR__.'/includes/header_user.php';
    } else {
      include __DIR__.'/includes/header_guest.php';
    }
  ?>

  <main class="main-content">
    <section class="contact-container">
      <div class="contact-card" style="max-width: 500px; margin: 0 auto;">
        <header>
          <h1>Login</h1>
        </header>

        <div class="contact-form" style="padding: 24px;">
          <?php if ($loginError): ?>
            <div class="form-status error" style="margin-bottom: 12px;">
              <?= htmlspecialchars($loginError) ?>
            </div>
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

            <div class="form-actions" style="margin-top: 16px;">
              <button type="submit" class="btn">Login</button>
            </div>
          </form>

          <p style="margin-top: 14px; font-family: Poppins, sans-serif;">
            Don't have an account?
            <a href="register.php" style="color: var(--teal); font-weight: 600;">Register here</a>
          </p>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
