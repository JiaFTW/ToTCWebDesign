<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password • Taste of the Caribbean</title>

  <link rel="stylesheet" href="css/gstyles.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

<?php
  if (isset($_SESSION['username'])) {
      include __DIR__ . '/includes/header_user.php';
  } else {
      include __DIR__ . '/includes/header_guest.php';
  }
?>

<main class="main-content">
  <section class="contact-container">
    <div class="contact-card" style="max-width: 500px; margin: 0 auto;">
      <header>
        <h1>Forgot Password</h1>
      </header>

      <div class="contact-form" style="padding: 24px;">
        <p style="margin-bottom: 18px; font-family: Poppins, sans-serif;">
          Enter your account email and we will send you a 6-digit reset code.
        </p>

        <form action="/backend/api/send_reset.php" method="POST">
          <div class="form-group">
            <label for="email">Email:</label>
            <input
              type="email"
              id="email"
              name="email"
              required
            >
          </div>

          <div class="form-actions" style="margin-top: 16px;">
            <button type="submit" class="btn">Send Reset Code</button>
          </div>
        </form>

        <p style="margin-top: 14px; font-family: Poppins, sans-serif;">
          Remember your password?
          <a href="/login.php" style="color: var(--teal); font-weight: 600;">
            Go back to Login
          </a>
        </p>
      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
