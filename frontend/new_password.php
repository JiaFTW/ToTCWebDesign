<?php
session_start();

// Only allow access if the reset email is stored
if (!isset($_SESSION['reset_email'])) {
    die("Unauthorized access.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create New Password • Taste of the Caribbean</title>

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
        <h1>Create New Password</h1>
      </header>

      <div class="contact-form" style="padding: 24px;">

        <p style="margin-bottom: 18px; font-family: Poppins, sans-serif;">
          Enter your new password below.
        </p>

        <form action="/backend/api/save_new_password.php" method="POST">
          
          <div class="form-group">
            <label for="password">New Password:</label>
            <input
              type="password"
              id="password"
              name="password"
              minlength="6"
              required
            >
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input
              type="password"
              id="confirm_password"
              name="confirm_password"
              minlength="6"
              required
            >
          </div>

          <div class="form-actions" style="margin-top: 18px;">
            <button type="submit" class="btn">Save Password</button>
          </div>
        </form>

      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
