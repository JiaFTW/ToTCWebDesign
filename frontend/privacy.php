<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy Policy • Taste of the Caribbean</title>

  <!-- Single unified stylesheet -->
  <link rel="stylesheet" href="css/gstyles.css">

  <!-- Fonts -->
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

  <main class="contact-container">
    <!-- Title strip -->
    <section class="location-header">
      <h1>Privacy Policy</h1>
    </section>

    <!-- Intro -->
    <section class="contact-card">
      <header>
        <h1>Overview</h1>
      </header>
      <div class="contact-form">
        <p>
          This Privacy Policy outlines how we collect, use, and safeguard your information when you visit our website.
        </p>
        <p>
          By using this site, you agree to the collection and use of information in accordance with this policy.
        </p>
      </div>
    </section>

    <!-- Information Collection and Use -->
    <section class="contact-card">
      <header>
        <h1>Information Collection and Use</h1>
      </header>
      <div class="contact-form">
        <p>
          We may collect personally identifiable information such as your name, email address, etc., at your discretion.
          Non-personally identifiable data is also collected to enhance your browsing experience.
        </p>
      </div>
    </section>

    <!-- Cookies -->
    <section class="contact-card">
      <header>
        <h1>Cookies</h1>
      </header>
      <div class="contact-form">
        <p>
          Our website uses cookies to help improve user experience and understand how you interact with our content.
          Cookies allow us to differentiate users and provide you with a personalized experience.
        </p>
      </div>
    </section>

    <!-- Data Security -->
    <section class="contact-card">
      <header>
        <h1>Data Security</h1>
      </header>
      <div class="contact-form">
        <p>
          We implement several security measures to protect your personal information. However, no method of transmission over the Internet
          or electronic storage is 100% secure.
        </p>
      </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-card">
      <header>
        <h1>Contact Information</h1>
      </header>
      <div class="contact-form">
        <p>
          If you have any questions or concerns regarding this privacy policy, please contact us at
          <a href="mailto:privacy@example.com">cfish@tocfoodmarket.com</a>.
        </p>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
