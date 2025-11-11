<?php
session_start();

// Check critical services FIRST
include __DIR__ . '/scripts/check-services.php';

// Display form status messages if they exist
$formStatus  = $_SESSION['form_status'] ?? '';
$formMessage = $_SESSION['form_message'] ?? '';
$formData    = $_SESSION['form_data'] ?? [];

// Clear session vars after showing message
unset($_SESSION['form_status'], $_SESSION['form_message'], $_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Catering • Taste of the Caribbean Restaurant & Catering</title>

    <!-- Unified stylesheet -->
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
      <section class="contact-card">
        <header>
          <h1>Catering Request</h1>
        </header>

        <div class="contact-form">
          <p>
            Let us cater your next big event! Submit your inquiry and we’ll get back to you within 1–2 business days.
          </p>

          <?php if ($formStatus): ?>
            <div class="form-message <?= htmlspecialchars($formStatus) ?>">
              <?= htmlspecialchars($formMessage) ?>
            </div>
          <?php endif; ?>

          <form id="orderForm" action="scripts/process-catering.php" method="POST">
            <div class="form-row">
              <div class="form-group">
                <label for="firstName" class="required">First Name</label>
                <input type="text" id="firstName" name="firstName" required
                       value="<?= htmlspecialchars($formData['firstName'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="lastName" class="required">Last Name</label>
                <input type="text" id="lastName" name="lastName" required
                       value="<?= htmlspecialchars($formData['lastName'] ?? '') ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="email" class="required">Email Address</label>
              <input type="email" id="email" name="email" required
                     pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                     value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="phone" class="required">Phone Number</label>
              <input type="tel" id="phone" name="phone" required
                     value="<?= htmlspecialchars($formData['phone'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="eventDate">Event Date</label>
              <input type="date" id="eventDate" name="eventDate"
                     value="<?= htmlspecialchars($formData['eventDate'] ?? date('Y-m-d', strtotime('+2 days'))) ?>">
            </div>

            <div class="form-group">
              <label for="orderDetails" class="required">Order Details</label>
              <textarea id="orderDetails" name="orderDetails" required
                        placeholder="Please specify what you would like to order and the quantities..."><?= htmlspecialchars($formData['orderDetails'] ?? '') ?></textarea>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn">Submit Request</button>
              <p class="notification">Fields marked with <span style="color:#e74c3c">*</span> are required</p>
            </div>
          </form>
        </div>
      </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script>
      document.getElementById('orderForm').addEventListener('submit', function(e) {
        const requiredFields = ['firstName','lastName','email','phone','orderDetails'];
        for (const id of requiredFields) {
          if (!document.getElementById(id).value.trim()) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
          }
        }

        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailRegex.test(email)) {
          e.preventDefault();
          alert('Please enter a valid email address.');
          return false;
        }
      });
    </script>
  </body>
</html>
