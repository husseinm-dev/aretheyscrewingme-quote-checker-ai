# Hostinger Deployment Guide

## 🏗️ Folder Structure on Hostinger

Your Hostinger server should have this structure:

```
/home/yourusername/
├── public_html/              ← PUBLIC (web accessible)
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
│   ├── guides/
│   ├── partials/
│   ├── tools/
│   ├── .htaccess
│   ├── robots.txt
│   ├── index.php
│   ├── upload.php
│   ├── pricing.php
│   └── ... (all other public PHP files)
│
├── config/                   ← SECURE (outside public)
│   ├── app.php              (your real config, NOT app.example.php)
│   └── bootstrap.php
│
├── src/                      ← SECURE (outside public)
│   ├── Auth.php
│   ├── Database.php
│   └── ... (all PHP classes)
│
├── vendor/                   ← SECURE (outside public)
│   └── ... (Composer packages)
│
├── storage/                  ← SECURE (outside public)
│   └── uploads/
│
├── sql/                      ← SECURE (optional, for reference)
│   └── schema.sql
│
├── composer.json
└── composer.lock
```

## 🚀 Deployment Workflow

### **Step 1: Initial Setup (One-time)**

1. **Install Node.js dependencies** (on local machine):

   ```bash
   cd /Applications/MAMP/htdocs/atsm-secure
   npm install
   ```

2. **Create `.env` or `config/app.php`** on server:
   - Copy `config/app.example.php` to `config/app.php`
   - Fill in your production values (database, Stripe keys, OpenAI key, etc.)

3. **Upload Composer dependencies**:

   ```bash
   # On server via SSH:
   cd /home/yourusername
   composer install --no-dev --optimize-autoloader
   ```

4. **Set proper permissions on server**:

   ```bash
   # Make storage writable
   chmod 755 storage
   chmod 755 storage/uploads

   # Make sure config files are secure
   chmod 600 config/app.php

   # Public folder should be readable
   chmod 755 public_html
   ```

5. **Import database schema**:
   ```bash
   mysql -u your_db_user -p your_db_name < sql/schema.sql
   ```

### **Step 2: Build for Production**

On your **local machine**, run:

```bash
npm run deploy
```

This creates a `hostinger/` folder with:

- ✅ Minified CSS (smaller file size)
- ✅ Minified JavaScript (remove console logs, compress)
- ✅ Optimized images (compressed)
- ✅ All PHP files (unchanged)
- ✅ Proper folder structure ready to upload

### **Step 3: Upload to Hostinger**

**Option A: Using Hostinger File Manager**

1. Go to Hostinger Control Panel → File Manager
2. Upload contents of `hostinger/public_html/` to your `public_html/`
3. Upload `hostinger/config/`, `hostinger/src/`, etc. to parent directory

**Option B: Using FTP/SFTP (Recommended)**

```bash
# Example with rsync (if you have SSH access):
rsync -avz --delete hostinger/public_html/ user@yourserver:/home/yourusername/public_html/
rsync -avz hostinger/config/ user@yourserver:/home/yourusername/config/
rsync -avz hostinger/src/ user@yourserver:/home/yourusername/src/
```

**Option C: Using FileZilla**

1. Connect to your Hostinger server
2. Navigate to `/home/yourusername/`
3. Drag & drop:
   - `hostinger/public_html/*` → `/public_html/`
   - `hostinger/config/` → `/config/`
   - `hostinger/src/` → `/src/`
   - `hostinger/storage/` → `/storage/`

### **Step 4: Verify Deployment**

1. **Check your site loads**: `https://yourdomain.com`
2. **Test a page**: `https://yourdomain.com/pricing`
3. **Check .htaccess is working** (clean URLs should work)
4. **Verify database connection** (try signup/login)
5. **Test file upload** (try analyzing a quote)

---

## 🔄 Updating Your Site (Regular Workflow)

### **Quick Update Workflow:**

1. **Make changes locally** (edit CSS, PHP, etc.)

2. **Build for production**:

   ```bash
   npm run deploy
   ```

3. **Upload only changed files** to Hostinger:
   - If you changed CSS: Upload `hostinger/public_html/assets/css/app.css`
   - If you changed PHP: Upload the specific PHP file
   - If you changed images: Upload the specific image

4. **Clear browser cache** to see changes

### **Example: CSS Update**

```bash
# 1. Edit CSS
vim public/assets/css/app.css

# 2. Build
npm run deploy

# 3. Upload via FTP
# Upload: hostinger/public_html/assets/css/app.css
# To: /public_html/assets/css/app.css
```

### **Example: PHP Logic Update**

```bash
# 1. Edit PHP class
vim src/QuoteAnalyzer.php

# 2. Build (copies files)
npm run deploy

# 3. Upload via FTP
# Upload: hostinger/src/QuoteAnalyzer.php
# To: /src/QuoteAnalyzer.php
```

---

## 🔒 Security Checklist

### **On Hostinger Server:**

- [ ] Config files are **outside** `public_html/`
- [ ] `config/app.php` has `chmod 600` permissions
- [ ] `storage/uploads/` has `chmod 755` permissions
- [ ] `.htaccess` is in `public_html/` and working
- [ ] `composer.json` is **outside** `public_html/`
- [ ] Database credentials use strong passwords
- [ ] Stripe webhook secret is set correctly
- [ ] OpenAI API key is set
- [ ] Session secret (`app_key`) is unique and strong

### **Verify .htaccess is Blocking:**

Try accessing:

- `https://yourdomain.com/config/app.php` → Should get 403 Forbidden
- `https://yourdomain.com/composer.json` → Should get 403 Forbidden
- `https://yourdomain.com/src/Auth.php` → Should get 403 Forbidden

### **Verify Clean URLs Work:**

- `https://yourdomain.com/upload` ✅ (not /upload.php)
- `https://yourdomain.com/pricing` ✅
- `https://yourdomain.com/tools/mechanic-quote-checker` ✅

---

## 🛠️ Troubleshooting

### **500 Internal Server Error**

1. Check `.htaccess` syntax
2. Verify PHP version (should be 8.1+)
3. Check file permissions
4. Enable error logging in `config/app.php`

### **Clean URLs Not Working**

1. Verify `.htaccess` is uploaded
2. Check if `mod_rewrite` is enabled (contact Hostinger)
3. Make sure `AllowOverride All` is set (usually default on Hostinger)

### **Database Connection Failed**

1. Update `config/app.php` with correct DB credentials
2. Verify database exists
3. Check if DB user has correct permissions
4. Test connection: `mysql -u user -p -h localhost database_name`

### **File Uploads Not Working**

1. Check `storage/uploads/` exists and is writable (chmod 755)
2. Verify `upload_max_filesize` in `.htaccess` or php.ini
3. Check PHP `post_max_size` setting

### **Stripe Payments Not Working**

1. Update webhook URL in Stripe Dashboard: `https://yourdomain.com/webhook`
2. Verify Stripe keys in `config/app.php` (use LIVE keys, not test)
3. Check webhook secret matches

---

## 📦 What NOT to Upload

❌ **Never upload these to Hostinger:**

- `node_modules/` (local development only)
- `.git/` (version control, not needed on server)
- `.vscode/` (editor config, local only)
- `DEPLOYMENT.md` (this file, optional)
- `gulpfile.js` (build tool, local only)
- `package.json` (build tool, local only)
- `config/app.example.php` (only upload `app.php`)

---

## 🎯 Quick Reference Commands

```bash
# Build for production
npm run deploy

# Watch for changes during development (local only)
npm run watch

# Clean build folder
gulp clean

# Build only CSS
gulp css

# Build only JS
gulp js

# Build only images
gulp images
```

---

## 📞 Hostinger Support

If you need help with:

- Enabling `mod_rewrite`
- Setting PHP version
- Database creation
- SSH access
- SSL certificate

Contact: Hostinger Support (they're usually very fast)

---

## ✅ Final Checklist Before Go Live

- [ ] SSL certificate is installed (HTTPS working)
- [ ] Database imported and configured
- [ ] `config/app.php` has production values
- [ ] Stripe live keys are set
- [ ] OpenAI API key is set
- [ ] `.htaccess` is working (clean URLs + security)
- [ ] File uploads working
- [ ] Signup/login working
- [ ] Quote analysis working
- [ ] Stripe checkout working
- [ ] All pages loading correctly
- [ ] Mobile responsive checked
- [ ] Browser cache cleared for testing

**🎉 Your site is live!**
