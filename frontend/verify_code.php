<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify Reset Code • Taste of the Caribbean</title>

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
        <h1>Verify Reset Code</h1>
      </header>

      <div class="contact-form" style="padding: 24px;">

        <p style="margin-bottom: 18px; font-family: Poppins, sans-serif;">
          Enter the 6-digit code that was sent to your email.
        </p>

        <form action="/backend/api/check_reset_code.php" method="POST">
          <div class="form-group">
            <label for="email">Email:</label>
            <input
              type="email"
              id="email"
              name="email"
              required
            >
          </div>

          <div class="form-group">
            <label for="code">Verification Code:</label>
            <input
              type="text"
              id="code"
              name="code"
              maxlength="6"
              required
            >
          </div>

          <div class="form-actions" style="margin-top: 16px;">
            <button type="submit" class="btn">Verify Code</button>
          </div>
        </form>

        <p style="margin-top: 14px; font-family: Poppins, sans-serif;">
          Didn’t receive a code?
          <a href="/forgot_password.php" style="color: var(--teal); font-weight: 600;">
            Resend
          </a>
        </p>

      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
