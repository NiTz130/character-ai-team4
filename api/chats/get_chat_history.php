<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy session_id từ query string
$session_id = intval($_GET['session_id'] ?? 0);

if (!$session_id) {
    json_error("Thiếu session ID");
}

// Kiểm tra session chat có tồn tại của user không
$stmt = $conn->prepare("SELECT id FROM chat_sessions WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $session_id, $_SESSION['user_id']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    json_error("Không tìm thấy phiên chat");
}

// Lấy danh sách messages
$query = $conn->prepare("SELECT sender, message FROM chat_messages WHERE session_id = ? ORDER BY created_at ASC");
$query->bind_param("i", $session_id);
$query->execute();
$result = $query->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        "sender" => $row['sender'],
        "message" => $row['message']
    ];
}

json_success(["messages" => $messages]);
?>
