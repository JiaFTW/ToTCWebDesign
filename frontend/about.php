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
    <title>Taste of the Carribean</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #4a9aa3;
            color: black;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 1400px;
            margin: 5px 40px 40px 40px;
            padding: 30px;
            background-color: #f5bf7d;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .faculty-glyphic-regular {
            font-family: "Faculty Glyphic", serif;
            font-weight: 400;
            font-style: normal;
        }

        .profile-image {
            width: 250px;
            height: 250px;
            background-color: #f0f0f0;
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        h1 {
            text-align: center;
            margin-bottom: 36px;
            font-family: "Faculty Glyphic", serif;
        }
        p {
            line-height: 1.8;
            margin-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="css/navbar.css">
  </head>
  <body>
    <div class="container">
        <h1>About Taste of the Caribbean</h1>
        <div class="profile-image">
            <img src="/api/placeholder/250/250" alt="Chanice Fish">
        </div>
        <div class="about-text">
            <p>I am Chanice Fish, the proud founder of Taste of the Caribbean Restaurant and Catering. Born and raised in Jamaica, I launched my first business at the age of 16, driven by a passion to share the rich flavors and vibrant heritage of the Caribbean.</p>
            
            <p>After facing personal challenges, including the loss of my first store due to family dynamics, I moved to the United States to further my education and fulfill my dream of celebrating and reintroducing the Caribbean's rich culinary heritage. Taste of the Caribbean is more than just a restaurant; it is a community hub in Newark. We blend modern and traditional Caribbean cuisines, offer a unique coffee club with exclusive Caribbean blends, and provide a catering service that brings our distinctive flavors to your events.</p>
            
            <p>Our journey extends beyond the culinary arts; it's a commitment to community. We're dedicated to nurturing local talent through internships and training opportunities for college students, collaborating with local entrepreneurs whose missions align with ours, and actively supporting our community.</p>
            
            <p>Join us at Taste of the Caribbean, where every meal is a celebration of culture, history, and the enduring spirit of the Caribbean. Experience the warmth of our hospitality and the unforgettable flavors that we bring to every plate.</p>
        </div>
    </div>
</body>
</html>