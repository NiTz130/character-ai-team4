<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy user ID từ session
$user_id = intval($_SESSION['user_id']);

// Lấy tất cả character mà user đã từng chat
$sql = "
SELECT DISTINCT c.id, c.name, c.avatar 
FROM chat_sessions cs 
JOIN characters c ON cs.character_id = c.id 
WHERE cs.user_id = ?
ORDER BY cs.updated_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$list = [];
while ($row = $result->fetch_assoc()) {
    $avatar = $row['avatar'] ?: 'assets/user.svg';

    if (!preg_match('/^https?:\/\//', $avatar) && !str_starts_with($avatar, 'assets/') && !str_starts_with($avatar, 'uploads/')) {
        $avatar = "assets/avatars/" . $avatar;
    }

    $list[] = [
        "id" => intval($row['id']),
        "name" => $row['name'],
        "avatar" => $avatar
    ];
}

json_success(["characters" => $list]);
?>
