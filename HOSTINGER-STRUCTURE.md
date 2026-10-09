# Hostinger Folder Structure Visual Guide

## 🏠 LOCAL (Your Computer) vs 🌐 HOSTINGER (Server)

```
┌─────────────────────────────────────────────────────────────────────┐
│                      LOCAL STRUCTURE                                │
└─────────────────────────────────────────────────────────────────────┘

atsm-secure/
├── public/                    ← Your web files
│   ├── assets/
│   │   ├── css/app.css
│   │   ├── js/
│   │   └── img/
│   ├── index.php
│   ├── upload.php
│   ├── pricing.php
│   └── .htaccess
├── config/                    ← Private config
│   ├── app.php
│   └── bootstrap.php
├── src/                       ← PHP classes
│   ├── Auth.php
│   ├── Database.php
│   └── ...
├── vendor/                    ← Composer packages
├── storage/                   ← File uploads
│   └── uploads/
├── gulpfile.js
└── package.json


┌─────────────────────────────────────────────────────────────────────┐
│                    AFTER `npm run deploy`                           │
└─────────────────────────────────────────────────────────────────────┘

hostinger/                     ← Ready to upload!
├── public_html/               ⬆️  Upload to Hostinger public_html/
│   ├── assets/
│   │   ├── css/app.css       (minified)
│   │   ├── js/               (minified)
│   │   └── img/              (optimized)
│   ├── index.php
│   ├── upload.php
│   └── .htaccess
├── config/                    ⬆️  Upload to /home/username/config/
│   ├── app.php
│   └── bootstrap.php
├── src/                       ⬆️  Upload to /home/username/src/
│   └── ...
├── storage/                   ⬆️  Upload to /home/username/storage/
│   └── uploads/
└── composer.json              ⬆️  Upload to /home/username/


┌─────────────────────────────────────────────────────────────────────┐
│                    HOSTINGER SERVER STRUCTURE                       │
└─────────────────────────────────────────────────────────────────────┘

/home/yourusername/
├── public_html/               ← ONLY THIS IS WEB ACCESSIBLE
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
│   ├── guides/
│   ├── partials/
│   ├── tools/
│   ├── .htaccess              ✅ Blocks access to parent folders
│   ├── robots.txt
│   ├── index.php
│   ├── upload.php
│   ├── pricing.php
│   └── ... (all other page files)
│
├── config/                    🔒 SECURE (not web accessible)
│   ├── app.php                ← Your production config
│   └── bootstrap.php
│
├── src/                       🔒 SECURE (not web accessible)
│   ├── Auth.php
│   ├── Database.php
│   ├── OpenAIService.php
│   └── ... (all PHP classes)
│
├── vendor/                    🔒 SECURE (not web accessible)
│   └── ... (Composer packages)
│
├── storage/                   🔒 SECURE (not web accessible)
│   └── uploads/               ← File uploads stored here
│
├── composer.json
└── composer.lock
```

---

## 🎯 Upload Mapping

| Local Build Output        | Upload To        | Access Level |
| ------------------------- | ---------------- | ------------ |
| `hostinger/public_html/*` | `/public_html/`  | 🌐 PUBLIC    |
| `hostinger/config/`       | `/config/`       | 🔒 PRIVATE   |
| `hostinger/src/`          | `/src/`          | 🔒 PRIVATE   |
| `hostinger/storage/`      | `/storage/`      | 🔒 PRIVATE   |
| `hostinger/composer.json` | `/composer.json` | 🔒 PRIVATE   |

---

## 🔐 Security Layers

### **Layer 1: Folder Structure**

```
/home/yourusername/           ← Root (secure)
├── public_html/              ← Only this is web accessible
└── everything else/          ← Not accessible via web
```

### **Layer 2: .htaccess Protection**

Located in `/public_html/.htaccess`:

- Blocks `../config/`
- Blocks `../src/`
- Blocks `../vendor/`
- Blocks `.env`, `composer.json`, etc.

### **Layer 3: PHP Path Resolution**

In your PHP files:

```php
require_once __DIR__ . '/../config/bootstrap.php';
// This works because PHP can traverse up from public_html/
// But browsers/hackers cannot access it via URL
```

---

## 🚫 What Hackers CANNOT Access

Even if they try:

- ❌ `yourdomain.com/config/app.php` → 403 Forbidden
- ❌ `yourdomain.com/../config/app.php` → 403 Forbidden
- ❌ `yourdomain.com/composer.json` → 403 Forbidden
- ❌ `yourdomain.com/storage/uploads/file.pdf` → 403 Forbidden
- ❌ `yourdomain.com/src/Auth.php` → 403 Forbidden

---

## ✅ What IS Accessible

- ✅ `yourdomain.com/` → index.php loads
- ✅ `yourdomain.com/upload` → upload.php loads (clean URL)
- ✅ `yourdomain.com/assets/css/app.css` → CSS file loads
- ✅ `yourdomain.com/assets/img/logo.png` → Image loads
- ✅ `yourdomain.com/tools/mechanic-quote-checker` → Tool page loads

---

## 🔧 How It Works

1. **Web Server Setup:**
   - Hostinger points `yourdomain.com` → `/home/yourusername/public_html/`
   - Everything outside `public_html/` is not exposed to web

2. **PHP Includes Still Work:**

   ```php
   // In public_html/index.php:
   require_once __DIR__ . '/../config/bootstrap.php';  ✅ Works

   // bootstrap.php then loads:
   require_once __DIR__ . '/../vendor/autoload.php';   ✅ Works
   require_once __DIR__ . '/../src/Auth.php';          ✅ Works
   ```

3. **Browser Cannot Access:**
   - Browser only sees what's in `public_html/`
   - `.htaccess` adds extra protection
   - File paths resolve internally via PHP

---

## 📋 Pre-Deployment Checklist

Before uploading to Hostinger:

1. ✅ Run `npm run deploy` locally
2. ✅ Verify `hostinger/` folder was created
3. ✅ Check `hostinger/public_html/.htaccess` exists
4. ✅ Review `hostinger/config/app.php` has production values
5. ✅ Ensure database is created on Hostinger
6. ✅ Upload files maintaining exact folder structure
7. ✅ Set `storage/uploads/` to chmod 755
8. ✅ Set `config/app.php` to chmod 600
9. ✅ Test website loads at your domain
10. ✅ Verify security (try accessing `/config/app.php`)

---

## 🆘 Emergency: "Everything is broken!"

If your site shows errors after deployment:

1. **Check file permissions:**

   ```bash
   chmod 755 public_html
   chmod 755 storage/uploads
   chmod 600 config/app.php
   ```

2. **Verify .htaccess was uploaded:**

   ```bash
   ls -la public_html/.htaccess
   ```

3. **Check PHP error logs:**
   - Hostinger Control Panel → Error Logs
   - Or check `storage/logs/app.log`

4. **Test database connection:**

   ```bash
   mysql -u your_user -p -h localhost your_database
   ```

5. **Verify composer autoload:**

   ```bash
   cd /home/yourusername
   composer dump-autoload
   ```

6. **Contact Hostinger support:**
   - 24/7 live chat
   - Usually respond in < 5 minutes

---

## 🎓 Understanding the Security

**Why is this setup secure?**

1. **Web root isolation:**
   - Only `public_html/` is exposed to internet
   - Config, source code, uploads are outside web root

2. **Multiple protection layers:**
   - Folder structure (primary)
   - .htaccess rules (secondary)
   - File permissions (tertiary)

3. **No sensitive data in URLs:**
   - Database credentials: in `/config/app.php` (not accessible)
   - API keys: in `/config/app.php` (not accessible)
   - Uploaded files: in `/storage/` (not accessible)

4. **Clean URLs hide technology:**
   - No `.php` extensions
   - Harder to probe for vulnerabilities
   - Better for SEO

**This is industry-standard security for PHP applications!**
