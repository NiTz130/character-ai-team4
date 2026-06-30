# 🤝 Đóng góp cho OpenCharacter

## Quy trình

1. **Fork** repo và tạo branch: `git checkout -b feat/ten-tinh-nang`
2. **Cài XAMPP** (PHP 8.x + MySQL 8) và clone project vào `htdocs/`
3. **Tạo database** `opencharacter` + import schema
4. **Cấu hình** `api/config.php` (DB + OpenAI key của bạn)
5. **Code** theo quy ước bên dưới
6. **Test** trên localhost + test với tài khoản thật
7. **Commit** với [Conventional Commits](https://www.conventionalcommits.org/)
8. **Push** + mở Pull Request

## Quy tắc

### PHP
- PSR-12
- Dùng `require_once` thay vì `include`
- **Prepared statements** cho mọi query có user input
- Escape output: `htmlspecialchars($x, ENT_QUOTES, 'UTF-8')`
- Dùng `password_hash` / `password_verify` cho password

### JavaScript
- ES6+, dùng `fetch` API
- Không commit jQuery / framework nặng
- Async/await thay vì `.then().catch()`

### Security
- **Không commit** OpenAI API key thật
- **Không commit** `uploads/` (chứa avatar user)
- Dùng `.env` hoặc file ngoài `htdocs/` cho secrets

### Commit Convention

```
<type>(<scope>): <description>

Types: feat, fix, docs, style, refactor, test, chore
```

**Ví dụ**:
```
feat(chat): add streaming response for long messages
fix(auth): handle expired session gracefully
docs(readme): add API endpoint table and architecture diagram
```

## Báo lỗi

Mở issue với:
- Mô tả ngắn gọn
- Các bước tái hiện
- Screenshot lỗi (nếu UI)
- Browser + OS
- Log từ XAMPP (`xampp/apache/logs/error.log`)
