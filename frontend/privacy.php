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
    <title>Privacy Policy - Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/privacy.css">
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>
<body>
    <?php
        if (isset($_SESSION['username'])) {
            include __DIR__ . '/includes/header_user.php';
        } else {
            include __DIR__ . '/includes/header_guest.php';
        }
    ?>
    
    <div class="main-content">
        <div class="privacy-policy">
            <header class="privacy-header">
                <h1>Privacy Policy</h1>
            </header>
            <main>
                <section class="policy-box">
                    <p>This Privacy Policy outlines how we collect, use, and safeguard your information when you visit our website.</p>
                    <p>By using this site, you agree to the collection and use of information in accordance with this policy.</p>
                </section>
                
                <section class="policy-box">
                    <h2>Information Collection and Use</h2>
                    <p>We may collect personally identifiable information such as your name, email address, etc., at your discretion. Non-personally identifiable data is also collected to enhance your browsing experience.</p>
                </section>
                
                <section class="policy-box">
                    <h2>Cookies</h2>
                    <p>Our website uses cookies to help improve user experience and understand how you interact with our content. Cookies allow us to differentiate users and provide you with a personalized experience.</p>
                </section>
                
                <section class="policy-box">
                    <h2>Data Security</h2>
                    <p>We implement several security measures to protect your personal information. However, no method of transmission over the Internet or electronic storage is 100% secure.</p>
                </section>
                
                <section class="policy-box">
                    <h2>Contact Information</h2>
                    <p>If you have any questions or concerns regarding this privacy policy, please contact us at <a href="mailto:privacy@example.com">privacy@example.com</a>.</p>
                </section>
            </main>
        </div>
    </div>
    <div>
      <?php include __DIR__.'/includes/footer.php'; ?>
    </div>  
</body>
</html>
