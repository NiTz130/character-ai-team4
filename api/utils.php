<?php

// Trả về JSON success
function json_success($data = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge(["success" => true], $data));
    exit;
}

// Trả về JSON error với code
function json_error($message, $code = 400) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => $message]);
    exit;
}

// Hàm sanitize input text chuẩn
function sanitize($text) {
    return htmlspecialchars(trim($text), ENT_QUOTES, 'UTF-8');
}
?>
