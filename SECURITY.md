# 🔒 Security Policy

## Reporting a Vulnerability

**KHÔNG tạo public issue** cho lỗ hổng bảo mật. Gửi qua GitHub profile của maintainer.

Bao gồm:
- Mô tả lỗ hổng
- Các bước tái hiện
- Mức độ ảnh hưởng (data exposure, XSS, SQLi, …)
- Đề xuất fix (nếu có)

## ⚠️ QUAN TRỌNG — Secrets

**KHÔNG BAO GIỜ** commit:

- OpenAI API key thật (`api/config.php` → `$openai_api_key`)
- MySQL root password
- Session secret
- File `uploads/` (chứa avatar user)

Nếu đã commit nhầm:
1. **Rotate** API key ngay lập tức
2. Dùng `git filter-repo` hoặc BFG Repo-Cleaner để xóa khỏi history
3. Force-push và thông báo co-author

## Best Practices

- Dùng biến môi trường (`getenv()`) thay vì hardcode secret trong `config.php`
- Validate mọi input server-side
- Prepared statements cho SQL
- `htmlspecialchars` cho mọi output HTML
- HTTPS cho production
- Set `session.cookie_httponly = 1` và `session.cookie_secure = 1` (HTTPS)
