<?php
// backend/api/db_connect_tocapp.php
// only opens a PDO to tocapp.ap_item_master—no session or includes.

try {
    $pdo = new PDO(
      'mysql:host=toc-dev.chaqko2e2i9g.us-east-1.rds.amazonaws.com;dbname=tocapp;charset=utf8',
      'toc_dev',
      'toc2024!',
      [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
      'error'   => 'Unable to connect to tocapp database',
      'message' => $e->getMessage()
    ]);
    exit;
}
