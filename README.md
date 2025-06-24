# OpenCharacter

Dự án Web App mô phỏng hệ thống tạo và trò chuyện với nhân vật ảo dựa trên trí tuệ nhân tạo GPT của OpenAI.  
Người dùng có thể tạo nhân vật với mô tả riêng, phân loại tự động bằng AI, lưu lại lịch sử trò chuyện và trải nghiệm chat như ChatGPT.

---

## Tính năng chính

- Đăng ký / Đăng nhập / Quên mật khẩu
- Tạo nhân vật ảo (avatar, mô tả, giới thiệu, lời chào)
- Tự động phân loại thể loại nhân vật bằng GPT API
- Trò chuyện với nhân vật theo thời gian thực
- Ghi lại lịch sử chat, lọc theo nhân vật
- Bảng xếp hạng các nhân vật phổ biến nhất
- Giao diện responsive, dễ sử dụng
- Quản lý hồ sơ người dùng (tên, avatar...)

---

## Công nghệ sử dụng

| Thành phần | Công nghệ |
|------------|-----------|
| Frontend   | HTML, CSS, JS (vanilla), AJAX |
| Backend    | PHP 8.x (REST API) |
| Database   | MySQL |
| AI API     | OpenAI GPT (Chat Completion API) |
| Session    | PHP Session |
| File upload | Avatar user và character (base64 hoặc file) |

---

## Cấu trúc thư mục
```bash
/
├── index.html              # Trang chính
├── createcharacter.html    # Tạo nhân vật
├── chat.html               # Giao diện chat
├── chatlist.html           # Lịch sử chat
├── leaderboard.html        # Bảng xếp hạng
├── profile.html            # Hồ sơ người dùng
├── login/register/...      # Các trang xác thực
├── api/                    # Toàn bộ API RESTful
├── uploads/                # Lưu avatar người dùng
├── css/style.css           # CSS chính
```
---

## Cài đặt nhanh (Localhost)
 - Clone dự án
 - Tạo database opencharacter trong MySQL
 - Cấu hình config.php
   ```bash
    $db_user = 'root';
    $db_pass = '';
    $openai_api_key = 'sk-...'; // Thay bằng key GPT của bạn
 - Mở bằng XAMPP hoặc PHP server

---

## Tác giả
Tên: Nguyễn Lê Đức Bình & Đinh Hoàng Phú

Lớp: 26TH01

Giáo viên hướng dẫn: ThS. Trần Thịnh Mạnh Đức

Đồ án môn: Lập trình website (Web Programming)


