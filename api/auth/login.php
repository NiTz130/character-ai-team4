<?php
require_once '../config.php';
require_once '../utils.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = sanitize($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
    json_error("Vui lòng nhập đầy đủ thông tin");
}

$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    json_error("Email không tồn tại", 404);
}

$stmt->bind_result($user_id, $hashed_password);
$stmt->fetch();

if (!password_verify($password, $hashed_password)) {
    json_error("Mật khẩu không đúng", 401);
}

$_SESSION['user_id'] = $user_id;

json_success(["message" => "Đăng nhập thành công", "user_id" => $user_id]);
?>
