<?php
require __DIR__ . "/db.php";
header('Content-Type: application/json; charset=utf-8');

$date = $_GET["date"] ?? null;
$time = $_GET["time"] ?? null;

if (!$date || !$time) {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "Missing date/time"]);
  exit;
}

$stmt = $conn->prepare("
  SELECT table_code
  FROM reservations
  WHERE reserve_date = ? AND reserve_time = ? AND status = 'ACTIVE'
");
$stmt->bind_param("ss", $date, $time);
$stmt->execute();
$res = $stmt->get_result();

$tables = [];
while ($row = $res->fetch_assoc()) {
  $tables[] = $row["table_code"];
}

echo json_encode(["ok" => true, "reservedTables" => $tables]);
