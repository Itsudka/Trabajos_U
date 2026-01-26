<?php
// api/db.php
$host = "127.0.0.1";
$user = "root";
$pass = "";           
$db   = "cafe_hogar";
$port = 3306;      

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
  $conn = new mysqli($host, $user, $pass, $db, $port);
  $conn->set_charset("utf8mb4");
} catch (Exception $e) {
  http_response_code(500);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(["ok" => false, "error" => "DB connection failed"]);
  exit;
}
