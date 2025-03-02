<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../backend/producer.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    sendMessageToQueue("login", [
        "username" => $username,
        "password" => $password
    ]);
    
    echo "Login request sent!";
}
?>