<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy user_id từ session
$user_id = intval($_SESSION['user_id']);

// Lấy thông tin user
$stmt = $conn->prepare("SELECT id, email, name, description, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $avatar = $row['avatar'] ?: 'assets/user.svg';

    if (!preg_match('/^https?:\/\//', $avatar) && !str_starts_with($avatar, 'assets/') && !str_starts_with($avatar, 'uploads/')) {
        $avatar = 'assets/avatars/' . $avatar;
    }

    $data = [
        "id" => intval($row['id']),
        "name" => $row['name'],
        "email" => $row['email'],
        "description" => $row['description'] ?? '',
        "avatar" => $avatar
    ];

    json_success(["profile" => $data]);
} else {
    json_error("Không tìm thấy người dùng", 404);
}
?>
