<?php
/* ------ REGISTER USER: write to DB immediately, also push to queue ------ */
session_start();
require_once __DIR__.'/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/* ---------- 1. Validate ---------- */
foreach (['email','full_name','password','confirm_password'] as $f) {
    if (empty($_POST[$f]))   die("❌ Missing $f");
}
$email    = trim($_POST['email']);
$name     = trim($_POST['full_name']);
$phone    = trim($_POST['phone'] ?? '');
$pass     = $_POST['password'];
$confirm  = $_POST['confirm_password'];

if (!filter_var($email,FILTER_VALIDATE_EMAIL))   die('❌ Bad e‑mail');
if (strlen($pass) < 6)                           die('❌ Password too short');
if ($pass !== $confirm)                          die('❌ Passwords differ');
$hash = password_hash($pass, PASSWORD_BCRYPT);

/* ---------- 2. Write to MySQL immediately ---------- */
require_once __DIR__.'/database.php';
$db = getDB();

/* duplicate‑e‑mail guard */
$dupe = $db->prepare("SELECT 1 FROM users WHERE email=?");
$dupe->execute([$email]);
if ($dupe->fetchColumn()) die('❌ E‑mail already registered.');

$ins = $db->prepare("
  INSERT INTO users (email, full_name, phone, password_hash)
  VALUES           (:e   , :n       , :p   , :h)
");
$ins->execute([
  'e'=>$email,
  'n'=>$name,
  'p'=>$phone ?: null,
  'h'=>$hash
]);

/* ---------- 3. Also push to RabbitMQ (analytics / welcome‑mail, etc.) ---------- */
try {
    $mq = new AMQPStreamConnection('98.82.149.231',5672,'totc','Totc2025');
    $ch = $mq->channel();
    $ch->queue_declare('user_requests',false,true,false,false);

    $msg = new AMQPMessage(json_encode([
        'action' => 'register_log',
        'email'  => $email,
        'time'   => date('c')
    ]), ['delivery_mode'=>2]);

    $ch->basic_publish($msg,'','user_requests');
    $ch->close(); $mq->close();
} catch (Throwable $e) {
    /* log but do NOT block the user */
    error_log('RabbitMQ push failed: '.$e->getMessage());
}

/* ---------- 4. Log the user in & redirect ---------- */
$_SESSION['username']=$email;
header('Location: /index.php');
exit;
