<?php
/* -------- Taste of the Caribbean – Registration page -------- */
session_start();
include __DIR__.'/scripts/check-services.php';

/* show correct navbar */
if (isset($_SESSION['username'])) {
    include __DIR__.'/includes/header_user.php';
} else {
    include __DIR__.'/includes/header_guest.php';
}
?>
<!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register • Taste of the Caribbean</title>

  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/global.css">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans&family=Poppins&display=swap" rel="stylesheet">

  <script>
  /* client‑side form guard */
  function validateForm () {
      const email   = document.getElementById('email').value.trim();
      const pass    = document.getElementById('password').value;
      const confirm = document.getElementById('confirm_password').value;

      if (!/^[^@]+@[^@]+\.[^@]+$/.test(email)) {
          alert('Please enter a valid e‑mail address.'); return false;
      }
      if (pass.length < 6) {
          alert('Password must be at least 6 characters.'); return false;
      }
      if (pass !== confirm) {
          alert('Passwords do not match.'); return false;
      }
      return true;
  }
  </script>
</head>
<body>
  <div class="container">
    <h1>Create an Account</h1>

    <!-- absolute path so it works no matter where the page lives -->
    <form action="/backend/api/register_user.php"
          method="post" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required>
      </div>

      <div class="form-group">
        <label for="email">E‑mail:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone (optional):</label>
        <input type="text" id="phone" name="phone">
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
      </div>

      <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="/login.php">Log in</a></p>
  </div>

  <?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
