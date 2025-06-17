<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';
require_once '../gpt_helper.php';

// Lấy input từ client
$data = json_decode(file_get_contents("php://input"), true);
$session_id = intval($data['session_id'] ?? 0);
$message = sanitize($data['message'] ?? '');

if (!$session_id || $message === '') {
    json_error("Thiếu dữ liệu");
}

// Kiểm tra session chat có tồn tại
$stmt = $conn->prepare("SELECT id FROM chat_sessions WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $session_id, $_SESSION['user_id']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    json_error("Session không tồn tại");
}

// Lưu message user
$stmt = $conn->prepare("INSERT INTO chat_messages (session_id, sender, message, created_at) VALUES (?, 'user', ?, NOW())");
$stmt->bind_param("is", $session_id, $message);
$stmt->execute();

// Gọi GPT trả lời
$reply = call_gpt_api($message);

// Lưu message bot
$stmt = $conn->prepare("INSERT INTO chat_messages (session_id, sender, message, created_at) VALUES (?, 'bot', ?, NOW())");
$stmt->bind_param("is", $session_id, $reply);
$stmt->execute();

// Cập nhật thời gian cuối chat
$stmt = $conn->prepare("UPDATE chat_sessions SET updated_at = NOW() WHERE id = ?");
$stmt->bind_param("i", $session_id);
$stmt->execute();

json_success(["reply" => $reply]);
?>
