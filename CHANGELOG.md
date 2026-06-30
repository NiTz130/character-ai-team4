# 📝 Changelog

Tất cả thay đổi đáng chú ý của dự án sẽ được ghi lại tại file này.

Format dựa theo [Keep a Changelog](https://keepachangelog.com/vi/1.1.0/),
dự án tuân theo [Semantic Versioning](https://semver.org/lang/vi/).

## [1.0.0] - 2025-06-24

### Added
- Đăng ký / Đăng nhập / Quên mật khẩu (PHP Session, `password_hash`).
- Tạo nhân vật ảo: avatar, mô tả, giới thiệu, lời chào.
- **Phân loại thể loại nhân vật tự động** qua OpenAI GPT API.
- Chat real-time với nhân vật qua OpenAI Chat Completion API.
- Lịch sử chat có lọc theo nhân vật.
- Bảng xếp hạng các nhân vật phổ biến nhất.
- Quản lý hồ sơ người dùng (tên, avatar base64 hoặc file upload).
- Responsive UI — dùng tốt trên desktop & mobile.
- MySQL schema với charset `utf8mb4` (hỗ trợ tiếng Việt có dấu).

### Authors
- Nguyễn Lê Đức Bình
- Đinh Hoàng Phú

GVHD: ThS. Trần Thịnh Mạnh Đức — Lớp 26TH01 — Môn Lập trình Website.
