<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy user ID từ session
$user_id = intval($_SESSION['user_id']);

// Lấy danh sách chat sessions
$stmt = $conn->prepare("
    SELECT cs.id AS session_id, c.name AS char_name, c.avatar 
    FROM chat_sessions cs 
    JOIN characters c ON cs.character_id = c.id 
    WHERE cs.user_id = ?
    ORDER BY cs.updated_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$list = [];
while ($row = $result->fetch_assoc()) {
    $avatar = $row['avatar'] ?: 'assets/user.svg';

    if (!preg_match('/^https?:\/\//', $avatar) && !str_starts_with($avatar, 'assets/') && !str_starts_with($avatar, 'uploads/')) {
        $avatar = 'assets/avatars/' . $avatar;
    }

    $list[] = [
        "session_id" => intval($row['session_id']),
        "char_name" => $row['char_name'],
        "avatar" => $avatar
    ];
}

json_success(["chats" => $list]);
?>
