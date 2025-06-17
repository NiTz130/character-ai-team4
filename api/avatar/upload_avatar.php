<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy user_id từ session
$user_id = intval($_SESSION['user_id']);

// Kiểm tra file upload
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    json_error("Chưa chọn file hoặc file lỗi");
}

$file = $_FILES['avatar'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (!in_array($ext, $allowed_ext)) {
    json_error("Chỉ cho phép file ảnh JPG, PNG, GIF, WEBP");
}

// Giới hạn kích thước file (ví dụ 5MB)
$max_size = 5 * 1024 * 1024;
if ($file['size'] > $max_size) {
    json_error("File quá lớn. Giới hạn 5MB");
}

// Đảm bảo thư mục uploads tồn tại
$upload_dir = '../uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$filename = 'user_'.$user_id.'_'.time().'.'.$ext;
$dest = $upload_dir . $filename;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    json_error("Lỗi khi upload file");
}

$avatar_path = 'uploads/'.$filename;

// Cập nhật avatar vào database
$stmt = $conn->prepare("UPDATE users SET avatar=? WHERE id=?");
$stmt->bind_param("si", $avatar_path, $user_id);
$stmt->execute();

json_success(["message" => "Upload avatar thành công", "avatar" => $avatar_path]);
?>
