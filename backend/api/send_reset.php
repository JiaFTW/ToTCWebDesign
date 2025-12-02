<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/database.php';
$db = getDB();

// Get email from the form
$email = trim($_POST['email'] ?? '');

if (!$email) {
    die("❌ Email is required.");
}

// Check if this email exists
$stmt = $db->prepare("SELECT email FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Don't reveal if the email exists
if (!$user) {
    echo "If this email exists, a reset code has been sent.";
    exit;
}

/* -----------------------
   1. Generate 6-digit code
   ----------------------- */
$code = random_int(100000, 999999);
$expires = date('Y-m-d H:i:s', time() + 600); // expires in 10 minutes

/* -----------------------
   2. Store reset code
   ----------------------- */
$upd = $db->prepare("
    UPDATE users 
    SET reset_code = ?, reset_expires = ?
    WHERE email = ?
");
$upd->execute([$code, $expires, $email]);

/* -----------------------
   3. Send to RabbitMQ queue
   ----------------------- */

$autoload = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;

    if (class_exists(\PhpAmqpLib\Connection\AMQPStreamConnection::class)) {
        try {
            $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
                '98.82.149.231', 5672, 'totc', 'Totc2025'
            );
            $channel = $connection->channel();

            // Queue name must match worker
            $channel->queue_declare('email_queue', false, true, false, false);

            $msg = new \PhpAmqpLib\Message\AMQPMessage(json_encode([
                'action' => 'send_reset_code',
                'email'  => $email,
                'code'   => $code
            ]), [
                'delivery_mode' => 2
            ]);

            $channel->basic_publish($msg, '', 'email_queue');

            $channel->close();
            $connection->close();

        } catch (Throwable $e) {
            error_log("RabbitMQ ERROR: " . $e->getMessage());
        }
    }
}

/* -----------------------
   4. Final user response
   ----------------------- */

echo "If this email exists, a reset code has been sent to it.";
exit;
