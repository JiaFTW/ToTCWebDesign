<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

// Connect to RabbitMQ
$connection = new AMQPStreamConnection('98.82.149.231', 5672, 'totc', 'Totc2025');
$channel = $connection->channel();

// Declare queue
$channel->queue_declare('user_requests', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

// MySQL Database Connection
$mysqli = new mysqli("toc-dev.chaqko2e2i9g.us-east-1.rds.amazonaws.com", "toc_dev", "toc2024!", "totc");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$callback = function ($msg) use ($mysqli) {
    echo " [x] Received ", $msg->body, "\n";
    $data = json_decode($msg->body, true);

    if ($data['action'] == 'register') {
        $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $data['username'], password_hash($data['password'], PASSWORD_BCRYPT));
        $stmt->execute();
        echo "User Registered: " . $data['username'] . "\n";
    } elseif ($data['action'] == 'login') {
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE username=?");
        $stmt->bind_param("s", $data['username']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "Login Successful for " . $data['username'] . "\n";
        } else {
            echo "Login Failed for " . $data['username'] . "\n";
        }
    } elseif ($data['action'] == 'order') {
        $stmt = $mysqli->prepare("INSERT INTO orders (username, order_data) VALUES (?, ?)");
        $stmt->bind_param("ss", $data['username'], json_encode($data['order']));
        $stmt->execute();
        echo "Order placed for " . $data['username'] . "\n";
    }
};

$channel->basic_consume('user_requests', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
