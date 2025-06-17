<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy input
$data = json_decode(file_get_contents("php://input"), true);
$name = sanitize($data['name'] ?? '');
$avatarBase64 = $data['avatar'] ?? null;

if (!$name && !$avatarBase64) {
    json_error("Không có dữ liệu cần cập nhật");
}

// Nếu có avatar base64 thì xử lý
if (!empty($avatarBase64)) {
    if (preg_match('/^data:image\/(\w+);base64,/', $avatarBase64, $type)) {
        $data = substr($avatarBase64, strpos($avatarBase64, ',') + 1);
        $data = base64_decode($data);
        if ($data === false) {
            json_error("Ảnh base64 không hợp lệ");
        }

        $ext = strtolower($type[1]);
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            json_error("Chỉ hỗ trợ JPG, PNG, WEBP");
        }

        if (!is_dir("../uploads/")) {
            mkdir("../uploads/", 0777, true);
        }

        $filename = uniqid("user_") . ".$ext";
        file_put_contents("../uploads/" . $filename, $data);
        $avatarFile = "uploads/" . $filename;

        // Cập nhật avatar vào DB
        $stmt = $conn->prepare("UPDATE users SET avatar=? WHERE id=?");
        $stmt->bind_param("si", $avatarFile, $_SESSION['user_id']);
        $stmt->execute();
    } else {
        json_error("Dữ liệu ảnh không hợp lệ");
    }
}

// Nếu có name thì update name
if (!empty($name)) {
    $stmt = $conn->prepare("UPDATE users SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $_SESSION['user_id']);
    $stmt->execute();
}

json_success(["message" => "Cập nhật hồ sơ thành công"]);
?>
