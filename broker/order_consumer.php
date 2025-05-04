<?php
// broker/order_consumer.php

require_once __DIR__.'/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once __DIR__.'/../backend/api/database.php';
$db = getDB();

// connect & consume
$conn = new AMQPStreamConnection('98.82.149.231', 5672, 'totc','Totc2025');
$ch   = $conn->channel();
$ch->queue_declare('orders', false, true, false, false);

$callback = function($msg) use ($db) {
    $data = json_decode($msg->body, true);
    $email = $data['user'] ?? '';
    if (!$email) { $msg->ack(); return; }

    // lookup user
    $u = $db->prepare("SELECT user_id, loyalty_points FROM users WHERE email=:e");
    $u->execute(['e'=>$email]);
    $row = $u->fetch(PDO::FETCH_ASSOC);
    if (!$row) { $msg->ack(); return; }

    // insert into orders
    $ins = $db->prepare("
      INSERT INTO orders (user_id, total, stripe_session_id)
      VALUES (:uid, :tot, :ssid)
    ");
    $ins->execute([
      'uid'  => $row['user_id'],
      'tot'  => $data['total'],
      'ssid' => $data['id'],
    ]);
    $orderId = $db->lastInsertId();

    // items
    $it = $db->prepare("
      INSERT INTO order_items (order_id,item_name,quantity,price)
      VALUES (:oid,:name,:qty,:pr)
    ");
    foreach ($data['items'] as $i) {
        $it->execute([
          'oid'  => $orderId,
          'name' => $i['name'],
          'qty'  => $i['quantity'],
          'pr'   => $i['price'],
        ]);
    }

    // 1 point per $1
    $pts = intval($data['total']);
    if ($pts > 0) {
        $up = $db->prepare("
          UPDATE users 
             SET loyalty_points = loyalty_points + :pt
           WHERE user_id = :uid
        ");
        $up->execute(['pt'=>$pts,'uid'=>$row['user_id']]);
    }

    $msg->ack();
};

$ch->basic_qos(null,1,null);
$ch->basic_consume('orders','',false,false,false,false,$callback);
while ($ch->is_consuming()) $ch->wait();
