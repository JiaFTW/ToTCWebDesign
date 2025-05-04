<?php
// broker/order_consumer.php

// Autoload RabbitMQ & PDO helper
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPMailer\PHPMailer\PHPMailer;


// Connect to RabbitMQ
$conn = new AMQPStreamConnection(
    '98.82.149.231', 5672,
    'totc', 'Totc2025'
);
$ch = $conn->channel();
$ch->queue_declare('orders', false, true, false, false);

//Get a PDO instance via your shared database helper
require_once __DIR__ . '/../backend/api/database.php';
$db = getDB();

// Callback to process each order
$callback = function($msg) use ($db) {
    $data = json_decode($msg->body, true);
    $userEmail = $data['user'] ?? '';
    if (!$userEmail) {
        $msg->ack();
        return;
    }

    // Fetch user_id & existing loyalty
    $stmt = $db->prepare(
      "SELECT user_id, loyalty_points 
         FROM users 
        WHERE email = :e"
    );
    $stmt->execute(['e' => $userEmail]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$u) {
        $msg->ack();
        return;
    }

    // Insert order
    $stmt = $db->prepare(
      "INSERT INTO orders (user_id,total ,stripe_session_id)
             VALUES (:uid,:tot,:ssid)"
    );
    $stmt->execute([
      'uid' => $u['user_id'],
      'tot' => $data['total'],
      'ssid' => $data['id']
    ]);
    $orderId = $db->lastInsertId();

    // Insert each order item
    $insertItem = $db->prepare(
      "INSERT INTO order_items 
         (order_id, item_name, quantity, price)
       VALUES 
         (:oid, :name, :qty, :pr)"
    );
    foreach ($data['items'] as $it) {
        $insertItem->execute([
          'oid'  => $orderId,
          'name' => $it['name'],
          'qty'  => $it['quantity'],
          'pr'   => $it['price']
        ]);
    }

    // Update loyalty points (1 point per $10)
    $pointsToAdd = floor($data['total']);
    if ($pointsToAdd > 0) {
        $upd = $db->prepare(
          "UPDATE users 
              SET loyalty_points = loyalty_points + :pt 
            WHERE user_id = :uid"
        );
        $upd->execute([
          'pt'  => $pointsToAdd,
          'uid' => $u['user_id']
        ]);
    }

    // Acknowledge the message
    $msg->ack();
};

// Start consuming
$ch->basic_qos(null, 1, null);
$ch->basic_consume('orders', '', false, false, false, false, $callback);

while ($ch->is_consuming()) {
    $ch->wait();
}
