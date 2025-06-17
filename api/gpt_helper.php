<?php
// gpt_helper.php

// Dùng luôn từ config.php
global $openai_api_key;

// Nếu muốn, bạn có thể define model cố định tại đây
define('OPENAI_MODEL', 'gpt-3.5-turbo');

function classify_character($intro, $description) {
    global $openai_api_key;

    $categories = [
      "Thân thiện","Bí ẩn","Hài hước","Nghiêm túc","Thông thái",
      "Lãng mạn","Triết lý","Lịch sử","Tương lai","Giả tưởng",
      "Kinh dị","Tâm lý","Hành động","Người hướng dẫn","Phản diện","Anh hùng"
    ];

    $system_prompt = "Bạn là hệ thống phân loại nhân vật. Dựa trên thông tin dưới đây hãy chọn ra đúng 1 thể loại trong danh sách: [" . implode(", ", $categories) . "]. Nếu không khớp, hãy trả về 'Khác'.";

    $user_prompt = "Dòng giới thiệu: $intro\nMô tả: $description\nThể loại:";

    $postData = [
        "model" => OPENAI_MODEL,
        "messages" => [
            ["role" => "system", "content" => $system_prompt],
            ["role" => "user", "content" => $user_prompt]
        ],
        "temperature" => 0,
        "max_tokens" => 20
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $openai_api_key,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    if (curl_errno($ch) || !$response) {
        curl_close($ch);
        return "Khác";
    }
    curl_close($ch);

    $result = json_decode($response, true);
    $category = trim($result['choices'][0]['message']['content'] ?? "Khác");

    if (!in_array($category, $categories)) return "Khác";
    return $category;
}

// Hàm gọi GPT chung (cho chat)
function call_gpt_api($prompt) {
    global $openai_api_key;
    $model = 'gpt-3.5-turbo';

    $postData = [
        "model" => $model,
        "messages" => [
            ["role" => "system", "content" => "Bạn là một AI hỗ trợ trò chuyện cho người dùng."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.7,
        "max_tokens" => 2000
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $openai_api_key,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    if (curl_errno($ch) || !$response) {
        curl_close($ch);
        return "Xin lỗi, hiện tại hệ thống đang bận.";
    }
    curl_close($ch);

    $result = json_decode($response, true);
    return trim($result['choices'][0]['message']['content'] ?? "Xin lỗi, không có câu trả lời.");
}
?>
