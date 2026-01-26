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
  SELECT DISTINCT table_code
  FROM reservations
  WHERE reserve_date = ?
    AND status = 'ACTIVE'
    AND start_time <= ?
    AND end_time > ?
");

$stmt->bind_param("sss", $date, $time, $time);
$stmt->execute();
$res = $stmt->get_result();

$tables = [];
while ($row = $res->fetch_assoc()) {
  $tables[] = $row["table_code"];
}

echo json_encode(["ok" => true, "reservedTables" => $tables]);
