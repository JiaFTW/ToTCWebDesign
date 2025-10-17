<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

// Connect to RabbitMQ
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();
$channel->queue_declare('user_requests', false, true, false, false);

echo "[*] Waiting for messages. To exit press CTRL+C\n";

// Connect to MySQL
$mysqli = new mysqli("toc-dev.chaqko2e2i9g.us-east-1.rds.amazonaws.com", "toc_dev", "toc2024!", "totc");

if ($mysqli->connect_error) {
    die("❌ Database Connection Failed: " . $mysqli->connect_error);
} else {
    echo "✅ Connected to MySQL database: totc\n";
}

// Callback function to process messages
$callback = function ($msg) use ($mysqli) {
    echo "[x] Received " . $msg->body . "\n";

    $data = json_decode($msg->body, true);

    if (!isset($data['email']) || !isset($data['password']) || !isset($data['full_name'])) {
        echo "❌ Error: Missing fields.\n";
        return;
    }

    $email = trim($data['email']);
    $full_name = trim($data['full_name']);
    $phone = isset($data['phone']) ? trim($data['phone']) : null;
    $password = trim($data['password']);

    if (empty($email) || empty($full_name) || empty($password)) {
        echo "❌ Error: Empty fields.\n";
        return;
    }

    $stmt = $mysqli->prepare("INSERT INTO users (email, full_name, phone, password_hash) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "❌ Prepare failed: " . $mysqli->error . "\n";
        return;
    }
    $stmt->bind_param("ssss", $email, $full_name, $phone, $password);
    if (!$stmt->execute()) {
        echo "❌ Execution failed: " . $stmt->error . "\n";
    } else {
        echo "✅ User Registered: " . $email . "\n";
    }
};
// Keep script running to process messages
$channel->basic_consume('user_requests', '', false, true, false, false, $callback);

while (true) {
    try {
        $channel->wait();
    } catch (Exception $e) {
        echo "⚠️ Error processing message: " . $e->getMessage() . "\n";
        sleep(1);
    }
}

$channel->close();
$connection->close();
?>
