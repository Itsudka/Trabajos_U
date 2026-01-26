<?php
require __DIR__ . "/db.php";
header('Content-Type: application/json; charset=utf-8');

$body = json_decode(file_get_contents("php://input"), true);

$full_name = trim($body["full_name"] ?? "");
$email = trim($body["email"] ?? "");
$phone = trim($body["phone"] ?? "");
$subject = trim($body["subject"] ?? "");
$message = trim($body["message"] ?? "");

if ($full_name === "" || $email === "" || $subject === "" || $message === "") {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "Missing required fields"]);
  exit;
}

$stmt = $conn->prepare("
  INSERT INTO contacts (full_name, email, phone, subject, message)
  VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssss", $full_name, $email, $phone, $subject, $message);
$stmt->execute();

echo json_encode(["ok" => true, "id" => $conn->insert_id]);
