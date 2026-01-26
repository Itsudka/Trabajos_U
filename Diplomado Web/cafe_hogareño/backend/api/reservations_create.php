<?php
require __DIR__ . "/db.php";
header('Content-Type: application/json; charset=utf-8');

$body = json_decode(file_get_contents("php://input"), true) ?? [];

$table_code = trim($body["table_code"] ?? "");
$name       = trim($body["customer_name"] ?? "");
$email      = trim($body["email"] ?? "");
$phone      = trim($body["phone"] ?? "");
$date       = trim($body["reserve_date"] ?? "");
$start_time = trim($body["start_time"] ?? "");
$end_time   = trim($body["end_time"] ?? "");
$comments   = trim($body["comments"] ?? "");

// Requeridos
if ($table_code === "" || $name === "" || $email === "" || $date === "" || $start_time === "" || $end_time === "") {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "Missing required fields"]);
  exit;
}

// Validación básica: end_time > start_time
if ($end_time <= $start_time) {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "end_time must be greater than start_time"]);
  exit;
}

try {
  // (Opcional pero recomendado) Evitar choques: si hay una reserva que se cruza con ese rango, rechaza
  $check = $conn->prepare("
    SELECT 1
    FROM reservations
    WHERE table_code = ?
      AND reserve_date = ?
      AND status = 'ACTIVE'
      AND NOT (end_time <= ? OR start_time >= ?)
    LIMIT 1
  ");
  // 4 params
  $check->bind_param("ssss", $table_code, $date, $start_time, $end_time);
  $check->execute();
  $exists = $check->get_result()->num_rows > 0;

  if ($exists) {
    http_response_code(409);
    echo json_encode(["ok" => false, "error" => "Mesa ya reservada en ese rango"]);
    exit;
  }

  $stmt = $conn->prepare("
    INSERT INTO reservations
      (table_code, customer_name, email, phone, reserve_date, start_time, end_time, comments, status)
    VALUES
      (?, ?, ?, ?, ?, ?, ?, ?, 'ACTIVE')
  ");

  // 8 params => 8 letras
  $stmt->bind_param(
    "ssssssss",
    $table_code,
    $name,
    $email,
    $phone,
    $date,
    $start_time,
    $end_time,
    $comments
  );

  $stmt->execute();

  echo json_encode(["ok" => true, "id" => $conn->insert_id]);
} catch (mysqli_sql_exception $e) {
  http_response_code(500);
  echo json_encode(["ok" => false, "error" => "Server error"]);
}

