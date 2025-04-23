<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Taste of the Caribbean</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden;
        }

        body {
            background-color: #ffffff;
            position: relative;
            overflow-x: hidden;
            font-family: "DM Sans", Arial, sans-serif;
            color: #333;
        }

        h1, h2 {
            color: #333;
            font-family: Faculty Glyphic, serif;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 36px;
        }

        p {
            color: #333;
            font-family: Poppins, sans-serif;
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #56aab3;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-family: Poppins, sans-serif;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #56aab3;
            box-shadow: 0 0 0 2px rgba(86, 170, 179, 0.2);
        }

        button {
            display: inline-block;
            background-color: #56aab3;
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 6px;
            font-family: 'Faculty Glyphic', serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #f5bf7d;
            transform: translateY(-2px);
        }

        a {
            color: #56aab3;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            color: #f5bf7d;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="../backend/api/login_user.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
