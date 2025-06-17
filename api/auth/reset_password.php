<?php
require_once '../config.php';
require_once '../utils.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = sanitize($data['email'] ?? '');
$new_password = $data['new_password'] ?? '';

if (!$email || !$new_password) {
    json_error("Vui lòng nhập email và mật khẩu mới");
}

// Kiểm tra email có tồn tại không
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    json_error("Email không tồn tại", 404);
}

// Cập nhật mật khẩu mới
$new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $new_hashed, $email);
$stmt->execute();

json_success(["message" => "Đổi mật khẩu thành công"]);
?>
