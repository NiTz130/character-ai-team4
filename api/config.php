<?php
// config.php

// Thông tin MySQL
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "opencharacter";

// Kết nối MySQL
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// API Key GPT (⚠️ nhớ đổi key thật khi deploy)
$openai_api_key = "sk-xxxxxx";

// Khởi động session toàn cục
session_start();
?>
