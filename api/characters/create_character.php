<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';
require_once '../gpt_helper.php';

$data = json_decode(file_get_contents("php://input"), true);

// Lấy và lọc input
$name = sanitize($data['name'] ?? '');
$intro = sanitize($data['intro'] ?? '');
$description = sanitize($data['description'] ?? '');
$hello = sanitize($data['hello'] ?? '');
$avatarBase64 = $data['avatar'] ?? null;

if (!$name) {
    json_error("Vui lòng nhập tên nhân vật");
}

// Gọi GPT phân loại
$prompt = "Hãy phân loại thể loại cho nhân vật dựa trên mô tả sau: \"$intro $description\". Hãy trả về một trong các thể loại: Lịch sử, Giải trí, Học thuật, Hỗ trợ, Người nổi tiếng, Khác.";
$category = call_gpt_api($prompt);

// Xử lý avatar nếu có
$avatarFile = null;

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

        $filename = uniqid("avatar_") . ".$ext";
        file_put_contents("../uploads/" . $filename, $data);
        $avatarFile = "uploads/" . $filename;
    } else {
        json_error("Dữ liệu ảnh không hợp lệ");
    }
}

$stmt = $conn->prepare("INSERT INTO characters (user_id, name, intro, description, hello, avatar, category, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("issssss", $_SESSION['user_id'], $name, $intro, $description, $hello, $avatarFile, $category);
$stmt->execute();

json_success(["message" => "Đã tạo nhân vật thành công", "character_id" => $stmt->insert_id]);
?>
