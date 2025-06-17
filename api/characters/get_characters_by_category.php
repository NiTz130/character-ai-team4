<?php
require_once '../config.php';
require_once '../utils.php';

// Lấy dữ liệu từ query string
$cat = sanitize($_GET['category'] ?? '');
$q = sanitize($_GET['q'] ?? '');

$sql = "SELECT id, name, avatar, intro FROM characters WHERE 1=1 ";
$params = [];
$types = "";

// Lọc theo category
if ($cat && mb_strtolower($cat, "UTF-8") !== "tất cả") {
    $sql .= "AND category = ? ";
    $types .= "s";
    $params[] = $cat;
}

// Lọc theo từ khóa tìm kiếm
if ($q !== "") {
    $sql .= "AND (name LIKE ? OR intro LIKE ? OR description LIKE ?) ";
    $types .= "sss";
    $likeq = "%$q%";
    $params[] = $likeq;
    $params[] = $likeq;
    $params[] = $likeq;
}

$sql .= "ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();

$characters = [];
while ($row = $res->fetch_assoc()) {
    $avatar = $row['avatar'] ?: 'assets/user.svg';
    
    // Chuẩn hóa path avatar SaaS gọn hơn
    if (!preg_match('/^https?:\/\//', $avatar) && !str_starts_with($avatar, 'assets/') && !str_starts_with($avatar, 'uploads/')) {
        $avatar = 'assets/avatars/' . $avatar;
    }

    $characters[] = [
        "id" => intval($row['id']),
        "name" => $row['name'],
        "avatar" => $avatar,
        "intro" => $row['intro']
    ];
}

json_success(["characters" => $characters]);
?>
