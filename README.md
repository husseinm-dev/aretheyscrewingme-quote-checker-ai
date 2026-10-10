# AreTheyScrewingMe — AI Quote Checker

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![OpenAI](https://img.shields.io/badge/OpenAI-GPT--4-412991?logo=openai&logoColor=white)
![Stripe](https://img.shields.io/badge/Stripe-Payments-635BFF?logo=stripe&logoColor=white)
![Cloudflare](https://img.shields.io/badge/Cloudflare-Turnstile-F38020?logo=cloudflare&logoColor=white)
![Live](https://img.shields.io/badge/status-live-brightgreen)

Ever wonder if a mechanic, plumber, or contractor quote is fair? Upload the quote and get an instant AI analysis: a fair price range, a 0–100 score, red flags, and questions to ask.

**Live site:** [aretheyscrewingme.com](https://aretheyscrewingme.com)

A secure, SEO-optimized quote analysis platform built with PHP + MySQL for shared hosting (Hostinger).

## ✨ Features

- 🔍 AI-powered quote analysis (OpenAI GPT-4)
- 💳 Stripe payment integration (one-time + subscription)
- 🛡️ Comprehensive security (rate limiting, CSRF, XSS protection)
- 🚀 Optimized performance (minified CSS/JS, image compression)
- 📱 Fully responsive design with smooth animations
- 🔒 Clean URLs without .php extensions
- 🤖 Cloudflare Turnstile bot protection
- 📊 SEO optimized (meta tags, sitemap, robots.txt)

---

## 🚀 Deployment to Hostinger

### **Quick Start**

1. **Install dependencies locally:**

   ```bash
   npm install
   composer install
   ```

2. **Build for production:**

   ```bash
   npm run deploy
   ```

3. **Upload to Hostinger:**
   - Upload `hostinger/public_html/` contents to your Hostinger `public_html/`
   - Upload `hostinger/config/`, `hostinger/src/`, `hostinger/vendor/` to parent directory
   - Set up database and import `sql/schema.sql`
   - Configure `config/app.php` with production values

📖 **Full deployment guide:** See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed instructions

---

## 🛠️ Local Development

### **Requirements**

- PHP 8.1+
- MySQL 5.7+
- Composer
- Node.js 14+
- MAMP/XAMPP (or similar)

### **Setup**

1. **Clone and install:**

   ```bash
   composer install
   npm install
   ```

2. **Database:**
   - Create MySQL database
   - Import `sql/schema.sql`

3. **Configuration:**

   ```bash
   cp config/app.example.php config/app.php
   ```

   Update `config/app.php` with:
   - Database credentials
   - OpenAI API key
   - Stripe API keys
   - Session secret

4. **Point your local server (MAMP/XAMPP) to the public folder:**
   - Document root: `<project>/public`

5. **Access locally:**
   - `http://localhost:8000`

### **Development Workflow**

- **Make changes** to CSS/JS/PHP files
- **Auto-rebuild** (watch mode):
  ```bash
  npm run watch
  ```
- **Build for production:**
  ```bash
  npm run deploy
  ```

---

## 📁 Project Structure

```
atsm-secure/
├── public/              ← Web accessible (goes to public_html on Hostinger)
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
│   ├── guides/
│   ├── partials/
│   ├── tools/
│   └── *.php
│
├── config/              ← Secure (outside public on Hostinger)
│   ├── app.php
│   └── bootstrap.php
│
├── src/                 ← PHP classes (outside public on Hostinger)
│   ├── Auth.php
│   ├── Database.php
│   └── ...
│
├── storage/             ← Uploads (outside public on Hostinger)
│   └── uploads/
│
├── vendor/              ← Composer packages (outside public on Hostinger)
├── sql/                 ← Database schema
├── gulpfile.js          ← Build automation
├── package.json         ← Node dependencies
└── DEPLOYMENT.md        ← Detailed deployment guide
```

---

## 🔒 Security Features

- ✅ HTTPS enforcement
- ✅ Security headers (CSP, X-Frame-Options, etc.)
- ✅ Rate limiting (login, signup, upload, analysis)
- ✅ CSRF protection on all forms
- ✅ Password hashing (bcrypt)
- ✅ Session security (HTTPOnly, SameSite)
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS protection (HTML escaping)
- ✅ File upload validation (extension, MIME, size)
- ✅ Config files outside public directory
- ✅ Bot protection (Cloudflare Turnstile)

---

## 🎨 Build System (Gulp)

### **Available Commands:**

```bash
# Build everything for production
npm run deploy

# Watch files during development
npm run watch

# Clean build folder
gulp clean

# Build specific assets
gulp css        # Minify CSS
gulp js         # Minify JavaScript
gulp images     # Optimize images
```

### **What Gets Optimized:**

- **CSS:** Minified, IE9+ compatible
- **JavaScript:** Minified, console logs removed
- **Images:** Compressed (JPEG, PNG, SVG)
- **PHP:** Copied as-is
- **Output:** `hostinger/` folder ready to upload

---

## 🔧 Configuration

### **Required Settings (config/app.php):**

```php
'db' => [
    'host' => 'localhost',
    'name' => 'your_database',
    'user' => 'your_username',
    'password' => 'your_password',
],

'openai' => [
    'api_key' => 'sk-...',
    'model' => 'gpt-4o',
],

'stripe' => [
    'secret_key' => 'sk_live_...',
    'publishable_key' => 'pk_live_...',
    'webhook_secret' => 'whsec_...',
],

'app_key' => 'your-random-32-char-secret',
'base_url' => 'https://yourdomain.com',
```

### **Optional Settings:**

- Cloudflare Turnstile (bot protection)
- Trial limits (free credits per device)
- Rate limiting thresholds
- Session timeout

---

## 🧪 Testing Quote Analysis

1. Sign up for free account (2 free checks)
2. Upload a quote or paste text
3. Select category (mechanic, plumber, etc.)
4. Enter ZIP code
5. Get instant analysis with:
   - Fair price range
   - Score (0-100)
   - Red flags
   - Questions to ask

---

## 💳 Payment Flow

1. **Free Trial:** 2 free quote checks per device
2. **Single Report:** $4.99 (one-time)
3. **3-Report Pack:** $11.99 (one-time)
4. **Pro Plan:** $19/month (60 checks/month)

Handled via Stripe Checkout → Webhook confirms payment → Credits added

---

## 📊 SEO Features

- ✅ Comprehensive meta tags (title, description, keywords)
- ✅ Open Graph tags (social sharing)
- ✅ Twitter Card tags
- ✅ Canonical URLs
- ✅ Favicon support
- ✅ Clean URLs (no .php)
- ✅ Sitemap.xml (`/sitemap`)
- ✅ Robots.txt
- ✅ Structured data ready
- ✅ Mobile optimized
- ✅ Fast page loads

---

## 🐛 Troubleshooting

### **"500 Internal Server Error"**

- Check `.htaccess` syntax
- Verify PHP version (8.1+)
- Check file permissions
- Review error logs

### **"Database connection failed"**

- Update `config/app.php` credentials
- Verify database exists
- Check user permissions

### **"Clean URLs not working"**

- Verify `.htaccess` is uploaded
- Check `mod_rewrite` is enabled
- Contact Hostinger support

### **"File uploads failing"**

- Check `storage/uploads/` is writable (755)
- Verify `upload_max_filesize` in `.htaccess`
- Check PHP `post_max_size`

---

## 📦 Dependencies

### **PHP (Composer):**

- `smalot/pdfparser` - PDF text extraction
- `stripe/stripe-php` - Payment processing

### **JavaScript (NPM):**

- `gulp` - Build automation
- `gulp-clean-css` - CSS minification
- `gulp-terser` - JS minification
- `gulp-imagemin` - Image optimization

---

## 🔄 Update Workflow

1. Make changes locally
2. Test on MAMP
3. Run `npm run deploy`
4. Upload changed files from `hostinger/` folder
5. Clear browser cache
6. Test on live site

---

## 📞 Support

- **Hostinger Issues:** Contact Hostinger support
- **Stripe Setup:** Check Stripe dashboard
- **OpenAI API:** Verify API key and credits
- **Code Issues:** Check error logs in `storage/logs/`

---

## 🎯 Production Checklist

Before going live:

- [ ] SSL certificate installed (HTTPS)
- [ ] `config/app.php` has production values
- [ ] Database imported
- [ ] Composer packages installed (`composer install --no-dev`)
- [ ] File permissions set (755 for directories, 644 for files)
- [ ] `.htaccess` blocking config files
- [ ] Stripe webhook URL configured
- [ ] OpenAI API key active
- [ ] Test signup/login
- [ ] Test quote analysis
- [ ] Test payments
- [ ] Mobile responsive verified
- [ ] All pages loading correctly

---

## 📄 License

Proprietary - All rights reserved
