<?php
require_once '../config.php';
require_once '../utils.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = sanitize($data['email'] ?? '');
$password = $data['password'] ?? '';
$name = sanitize($data['name'] ?? '');

if (!$email || !$password || !$name) {
    json_error("Vui lòng nhập đầy đủ thông tin");
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    json_error("Email đã tồn tại", 409);
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $hashed_password, $name);
$stmt->execute();

json_success(["message" => "Đăng ký thành công"]);
?>
