<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy input từ client
$data = json_decode(file_get_contents("php://input"), true);
$character_id = intval($data['character_id'] ?? 0);

if (!$character_id) {
    json_error("Thiếu character_id");
}

// Tạo session chat mới
$stmt = $conn->prepare("INSERT INTO chat_sessions (user_id, character_id) VALUES (?, ?)");
$stmt->bind_param("ii", $_SESSION['user_id'], $character_id);
if ($stmt->execute()) {
    json_success(["message" => "Tạo chat thành công", "session_id" => $stmt->insert_id]);
} else {
    json_error("Tạo chat thất bại", 500);
}
?>
