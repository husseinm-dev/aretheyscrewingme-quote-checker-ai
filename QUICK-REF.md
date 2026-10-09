# 🚀 Quick Reference - Hostinger Deployment

## Daily Workflow Commands

```bash
# Make changes to your files
vim public/assets/css/app.css

# Build for production
npm run deploy
# OR use the helper script:
./deploy.sh

# Output ready in: hostinger/
```

---

## Common Update Scenarios

### 📝 CSS Changes

```bash
1. Edit: public/assets/css/app.css
2. Build: npm run deploy
3. Upload: hostinger/public_html/assets/css/app.css
   To: /public_html/assets/css/app.css
```

### 🔧 PHP Logic Changes

```bash
1. Edit: src/QuoteAnalyzer.php
2. Build: npm run deploy
3. Upload: hostinger/src/QuoteAnalyzer.php
   To: /src/QuoteAnalyzer.php
```

### 🖼️ Image Updates

```bash
1. Add image: public/assets/img/new-image.png
2. Build: npm run deploy
3. Upload: hostinger/public_html/assets/img/new-image.png
   To: /public_html/assets/img/new-image.png
```

### 📄 New Page Added

```bash
1. Create: public/new-page.php
2. Build: npm run deploy
3. Upload: hostinger/public_html/new-page.php
   To: /public_html/new-page.php
```

---

## Gulp Commands

| Command          | What It Does                 |
| ---------------- | ---------------------------- |
| `npm run deploy` | Full production build        |
| `npm run watch`  | Auto-rebuild on file changes |
| `gulp clean`     | Delete build folder          |
| `gulp css`       | Build only CSS               |
| `gulp js`        | Build only JavaScript        |
| `gulp images`    | Optimize images only         |

---

## File Locations

### On Your Computer (After Build)

```
hostinger/
├── public_html/     → Upload to Hostinger public_html/
├── config/          → Upload to /config/
├── src/             → Upload to /src/
├── storage/         → Upload to /storage/
└── composer.json    → Upload to /composer.json
```

### On Hostinger Server

```
/home/yourusername/
├── public_html/     ← Web accessible (PUBLIC)
├── config/          ← Not web accessible (SECURE)
├── src/             ← Not web accessible (SECURE)
├── storage/         ← Not web accessible (SECURE)
└── vendor/          ← Not web accessible (SECURE)
```

---

## Security Checks

Test these URLs (should all be blocked):

```
❌ yourdomain.com/config/app.php       → 403 Forbidden
❌ yourdomain.com/composer.json        → 403 Forbidden
❌ yourdomain.com/src/Auth.php         → 403 Forbidden
❌ yourdomain.com/vendor/autoload.php  → 403 Forbidden
```

Test these URLs (should work):

```
✅ yourdomain.com/                     → Homepage loads
✅ yourdomain.com/upload               → Upload page loads
✅ yourdomain.com/pricing              → Pricing page loads
✅ yourdomain.com/assets/css/app.css   → CSS loads
```

---

## Troubleshooting Quick Fixes

### "500 Error"

```bash
# Check .htaccess was uploaded
ls -la public_html/.htaccess

# Check PHP version (must be 8.1+)
php -v

# Check error logs
cat storage/logs/app.log
```

### "Database Error"

```bash
# Update config/app.php with correct credentials
vim config/app.php

# Test database connection
mysql -u user -p -h localhost database_name
```

### "Clean URLs Not Working"

```bash
# Verify .htaccess exists
ls public_html/.htaccess

# Check mod_rewrite is enabled (ask Hostinger)
```

### "File Upload Failing"

```bash
# Make storage writable
chmod 755 storage
chmod 755 storage/uploads

# Check PHP upload limits in .htaccess
```

---

## First-Time Setup (One-Time Only)

1. **Install dependencies**

   ```bash
   npm install
   composer install
   ```

2. **Create production config**

   ```bash
   cp config/app.example.php config/app.php
   # Edit config/app.php with production values
   ```

3. **Build for production**

   ```bash
   npm run deploy
   ```

4. **Upload to Hostinger**
   - Via FTP/FileZilla
   - Or Hostinger File Manager

5. **Set up database**

   ```bash
   # Create database in Hostinger panel
   # Import sql/schema.sql
   ```

6. **Install Composer packages on server**

   ```bash
   composer install --no-dev --optimize-autoloader
   ```

7. **Set file permissions**

   ```bash
   chmod 755 public_html
   chmod 755 storage/uploads
   chmod 600 config/app.php
   ```

8. **Test everything**
   - Visit your domain
   - Try signup/login
   - Test quote analysis
   - Verify payments work

---

## Support Contacts

- **Hostinger Issues:** Live chat in Hostinger panel
- **Stripe Setup:** dashboard.stripe.com
- **OpenAI API:** platform.openai.com
- **Deployment Help:** See DEPLOYMENT.md

---

## 📖 Full Documentation

- [DEPLOYMENT.md](DEPLOYMENT.md) - Complete deployment guide
- [HOSTINGER-STRUCTURE.md](HOSTINGER-STRUCTURE.md) - Folder structure explained
- [README.md](README.md) - Project overview

---

## Emergency Reset

If everything breaks:

1. **Backup current files**
2. **Rebuild locally:**
   ```bash
   gulp clean
   npm run deploy
   ```
3. **Re-upload everything from hostinger/ folder**
4. **Clear browser cache**
5. **Test each page**

---

**💡 Pro Tip:** Bookmark this file for quick access!
