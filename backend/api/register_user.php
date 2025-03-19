<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirm_password'])) {
    die("❌ Missing required fields.");
}

$email = trim($_POST['email']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("❌ Invalid email format.");
}

if (strlen($password) < 6) {
    die("❌ Password must be at least 6 characters long.");
}

if ($password !== $confirmPassword) {
    die("❌ Passwords do not match.");
}

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Connect to RabbitMQ
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();
$channel->queue_declare('user_requests', false, true, false, false);

// Create RabbitMQ message
$data = json_encode([
    "action" => "register",
    "email" => $email,
    "password" => $hashedPassword
]);

$msg = new AMQPMessage($data, ['delivery_mode' => 2]);
$channel->basic_publish($msg, '', 'user_requests');

$channel->close();
$connection->close();

echo "✅ Registration request sent!";
?>
