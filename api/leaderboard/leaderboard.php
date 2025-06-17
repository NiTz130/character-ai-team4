<?php
require_once '../config.php';
require_once '../utils.php';
require_once '../auth.php';

// Lấy top nhân vật có nhiều lượt chat nhất
$sql = "
SELECT c.id, c.name, c.avatar, u.name AS owner_name, COUNT(cs.id) AS session_count
FROM characters c
LEFT JOIN chat_sessions cs ON c.id = cs.character_id
LEFT JOIN users u ON c.user_id = u.id
GROUP BY c.id
ORDER BY session_count DESC, c.id ASC
LIMIT 20
";

$res = $conn->query($sql);
$list = [];

while ($row = $res->fetch_assoc()) {
    $list[] = [
        "id" => intval($row["id"]),
        "name" => $row["name"],
        "avatar" => $row["avatar"] ?: "assets/user.svg",
        "owner" => $row["owner_name"] ?: "Ẩn danh",
        "count" => intval($row["session_count"])
    ];
}

json_success(["characters" => $list]);
?>
