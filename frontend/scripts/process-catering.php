<?php
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $eventDate = $_POST['eventDate'] ?? '';
    $orderDetails = $_POST['orderDetails'] ?? '';

    // Validate required fields
    $errors = [];
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone)) $errors[] = "Phone is required";
    if (empty($orderDetails)) $errors[] = "Order details are required";
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // If no errors, process the form
    if (empty($errors)) {
        // Set up email
        $to = "shigary99@gmail.com"; // Replace with actual email
        $subject = "New Catering Inquiry from " . $firstName . " " . $lastName;
        
        $message = "New Catering Inquiry:\n\n";
        $message .= "Name: " . $firstName . " " . $lastName . "\n";
        $message .= "Email: " . $email . "\n";
        $message .= "Phone: " . $phone . "\n";
        $message .= "Event Date: " . $eventDate . "\n";
        $message .= "Order Details:\n" . $orderDetails . "\n";
        
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send email
        $mailSent = mail($to, $subject, $message, $headers);

        if ($mailSent) {
            $_SESSION['form_status'] = 'success';
            $_SESSION['form_message'] = 'Thank you for your inquiry! We will get back to you within 1-2 business days.';
        } else {
            $_SESSION['form_status'] = 'error';
            $_SESSION['form_message'] = 'There was an error sending your inquiry. Please try again later.';
        }
    } else {
        $_SESSION['form_status'] = 'error';
        $_SESSION['form_message'] = implode("<br>", $errors);
        $_SESSION['form_data'] = $_POST;
    }

    // Redirect back to contact page
    header("Location: contact.php");
    exit();
}
?> 