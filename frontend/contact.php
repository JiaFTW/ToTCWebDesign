<?php
session_start();

// Get any contact form status message
$contactStatus = $_SESSION['contact_status'] ?? '';
unset($_SESSION['contact_status']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us • Taste of the Caribbean</title>

  <link rel="stylesheet" href="css/gstyles.css">

  <!-- Fonts -->
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
    <div class="contact-card" style="max-width: 600px; margin: 0 auto;">
      
      <header>
        <h1>Contact Us</h1>
        <p style="font-family: Poppins, sans-serif; margin-top: 6px;">
          Have questions? Send us a message and we'll get back to you shortly.
        </p>
      </header>

      <div class="contact-form" style="padding: 24px;">

        <!-- Success / Error Message -->
        <?php if ($contactStatus): ?>
          <div class="form-status success" style="margin-bottom: 12px;">
            <?= htmlspecialchars($contactStatus) ?>
          </div>
        <?php endif; ?>

        <form action="/backend/api/contact_form.php" method="POST">

          <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
          </div>

          <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
          </div>

          <div class="form-actions" style="margin-top: 16px;">
            <button type="submit" class="btn">Send Message</button>
          </div>

        </form>

      </div>
    </div>
  </section>
</main>

<?php include __DIR__.'/includes/footer.php'; ?>

</body>
</html>
