<?php
require_once '../utils.php';

// Hủy toàn bộ session hiện tại
session_start();
session_unset();
session_destroy();

// Trả kết quả JSON thành công
json_success(["message" => "Đăng xuất thành công"]);
?>
