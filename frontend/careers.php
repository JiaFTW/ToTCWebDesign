<?php
session_start();

// Load header
if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Careers • Taste of the Caribbean</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap">
    <link rel="stylesheet" href="css/gstyles.css">

    <style>
        .careers-wrapper {
            max-width: 900px;
            margin: 40px auto 80px;
            background: var(--white);
            border-radius: 12px;
            padding: 35px;
            border: 2px solid var(--beige);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .careers-header {
            background: var(--teal);
            color: white;
            padding: 28px;
            border-radius: 12px 12px 0 0;
            margin: -35px -35px 30px -35px;
        }

        .careers-header h1 {
            font-family: 'DM Sans', sans-serif;
            font-size: 36px;
            margin: 0;
        }

        .field-label {
            font-weight: 700;
            color: var(--text);
            margin-top: 18px;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            border: 2px solid var(--beige);
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            font-family: 'DM Sans', sans-serif;
        }

        .form-control:focus {
            border-color: var(--teal);
        }

        .submit-btn {
            background: var(--teal);
            color: var(--white);
            padding: 14px 32px;
            border-radius: 8px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            margin-top: 25px;
            transition: 0.3s ease;
        }

        .submit-btn:hover {
            background: #006671;
        }

        .resume-input {
            padding: 10px;
            background: var(--white);
        }
    </style>
</head>

<body>

<div class="careers-wrapper">
    <div class="careers-header">
        <h1>Career Opportunities</h1>
        <p style="margin-top:10px;font-size:18px;color:white;">
            Join the Taste of the Caribbean team! Submit your application and we’ll contact you if you’re a match.
        </p>
    </div>

    <form action="/backend/api/careers_submit.php" method="POST" enctype="multipart/form-data">

        <label class="field-label">Full Name:</label>
        <input type="text" name="name" class="form-control" required>

        <label class="field-label">Email Address:</label>
        <input type="email" name="email" class="form-control" required>

        <label class="field-label">Phone Number:</label>
        <input type="text" name="phone" class="form-control" required>

        <label class="field-label">Upload Resume (PDF or DOCX):</label>
        <input type="file" name="resume" accept=".pdf,.doc,.docx" class="form-control resume-input" required>

        <label class="field-label">Tell Us About Yourself:</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>

        <button type="submit" class="submit-btn">Submit Application</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
