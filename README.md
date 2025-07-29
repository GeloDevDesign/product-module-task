# Laravel Template – Known Issues

### 1. ❌ MySQL Dump Error (DB Backup)
- **Error:** `DumpFailed::processDidNotEndSuccessfully`
- **Cause:** Missing `mysqldump` or misconfigured DB settings.
- **Fix:** Check `.env`, ensure `mysqldump` is installed and path is correct.

### 2. 📧 Mail Sending Failed
- **Error:** `getaddrinfo for mailhog failed`
- **Cause:** Mailhog not running or wrong host.
- **Fix:** Use `MAIL_HOST=127.0.0.1` and ensure Mailhog is running.

### 3. 🎨 UI & Store Request Issues
- **Error:** Product/Category UI not rendering or saving.
- **Cause:** Blade/component errors or failed validation.
- **Fix:** Check form bindings, validation, and controller logic.

