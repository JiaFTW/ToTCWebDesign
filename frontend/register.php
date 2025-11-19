<?php
/* -------- Taste of the Caribbean – Registration page -------- */
session_start();
include __DIR__.'/scripts/check-services.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account • Taste of the Caribbean</title>

  <!-- Use ONLY your unified theme -->
  <link rel="stylesheet" href="css/gstyles.css">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,500&family=Faculty+Glyphic&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <script>
    /* Client-side validation */
    function validateForm () {
        const email   = document.getElementById('email').value.trim();
        const pass    = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;

        if (!/^[^@]+@[^@]+\.[^@]+$/.test(email)) {
            alert('Please enter a valid email address.'); return false;
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

<?php
  if (isset($_SESSION['username'])) {
    include __DIR__.'/includes/header_user.php';
  } else {
    include __DIR__.'/includes/header_guest.php';
  }
?>

<main style="width:90%;max-width:1200px;margin:40px auto;">

<section class="contact-card" style="max-width:500px;margin:0 auto;">
  <header><h1>Create an Account</h1></header>

  <div class="contact-form">
    <form action="/backend/api/register_user.php"
          method="post"
          onsubmit="return validateForm()">

      <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone (optional)</label>
        <input type="text" id="phone" name="phone">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
      </div>

      <button type="submit" class="btn">Register</button>
    </form>

    <p style="margin-top:10px;">
      Already registered?
      <a href="/login.php" style="color:var(--teal);font-weight:600;">Log in</a>
    </p>
  </div>
</section>

</main>

<?php include __DIR__.'/includes/footer.php'; ?>
</body>
</html>
