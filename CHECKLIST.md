# ✅ Hostinger Deployment Checklist

Print this or keep it open during deployment!

---

## 🏁 PRE-DEPLOYMENT (Do These First)

### Local Setup

- [ ] Installed Node.js dependencies (`npm install`)
- [ ] Installed Composer dependencies (`composer install`)
- [ ] Created `config/app.php` from `config/app.example.php`
- [ ] Set all production values in `config/app.php`
- [ ] Tested locally on MAMP (everything works)
- [ ] Ran `npm run deploy` (hostinger/ folder created)
- [ ] Verified `hostinger/` folder has all files

### Hostinger Setup

- [ ] Created MySQL database
- [ ] Created database user with full permissions
- [ ] Noted down database credentials
- [ ] Have FTP/SFTP credentials ready
- [ ] Have Hostinger File Manager access
- [ ] SSL certificate is ready (or will install after)

---

## 📁 FILE UPLOAD (Follow This Order)

### Step 1: Upload Core Directories

- [ ] Upload `hostinger/config/` → `/home/yourusername/config/`
- [ ] Upload `hostinger/src/` → `/home/yourusername/src/`
- [ ] Upload `hostinger/storage/` → `/home/yourusername/storage/`
- [ ] Upload `hostinger/composer.json` → `/home/yourusername/composer.json`
- [ ] Upload `hostinger/composer.lock` → `/home/yourusername/composer.lock`

### Step 2: Upload Public Files

- [ ] Upload ALL files from `hostinger/public_html/` → `/public_html/`
- [ ] Verify `.htaccess` is in `/public_html/.htaccess`
- [ ] Verify `robots.txt` is in `/public_html/robots.txt`
- [ ] Check all folders copied (assets/, guides/, tools/, partials/)

### Step 3: Composer Dependencies

- [ ] SSH into server (or use Hostinger terminal)
- [ ] Run: `cd /home/yourusername`
- [ ] Run: `composer install --no-dev --optimize-autoloader`
- [ ] Wait for installation to complete

---

## 🗄️ DATABASE SETUP

- [ ] Go to Hostinger Panel → Databases
- [ ] Create new database (note the name)
- [ ] Create database user (note username/password)
- [ ] Grant ALL privileges to user on database
- [ ] Open phpMyAdmin
- [ ] Select your database
- [ ] Click "Import"
- [ ] Upload `sql/schema.sql`
- [ ] Click "Go" to import
- [ ] Verify tables were created (users, reports, etc.)

---

## ⚙️ CONFIGURATION

### Update config/app.php on Server

- [ ] Edit `/home/yourusername/config/app.php`
- [ ] Set `db.host` (usually 'localhost')
- [ ] Set `db.name` (your database name)
- [ ] Set `db.user` (your database username)
- [ ] Set `db.password` (your database password)
- [ ] Set `base_url` (https://yourdomain.com)
- [ ] Set `openai.api_key` (your OpenAI key)
- [ ] Set `stripe.secret_key` (sk*live*...)
- [ ] Set `stripe.publishable_key` (pk*live*...)
- [ ] Set `stripe.webhook_secret` (whsec\_...)
- [ ] Set unique `app_key` (random 32 chars)
- [ ] Save file

---

## 🔐 FILE PERMISSIONS

Run these commands via SSH or Hostinger terminal:

```bash
cd /home/yourusername

# Set directory permissions
chmod 755 public_html
chmod 755 config
chmod 755 src
chmod 755 storage
chmod 755 storage/uploads
chmod 755 vendor

# Set file permissions
chmod 600 config/app.php
chmod 644 public_html/.htaccess
chmod 644 composer.json

# Make storage writable by web server
chown -R yourusername:yourusername storage/uploads
```

Checklist:

- [ ] `public_html` is 755
- [ ] `storage/uploads` is 755
- [ ] `config/app.php` is 600
- [ ] `.htaccess` is 644

---

## 🌐 DOMAIN & SSL SETUP

- [ ] Domain pointed to your Hostinger server
- [ ] DNS propagated (can take up to 48 hours)
- [ ] SSL certificate installed (Hostinger usually auto-installs)
- [ ] Site loads with HTTPS: `https://yourdomain.com`
- [ ] HTTP redirects to HTTPS automatically

---

## 🧪 FUNCTIONALITY TESTING

### Basic Pages

- [ ] Homepage loads: `https://yourdomain.com`
- [ ] Upload page loads: `https://yourdomain.com/upload`
- [ ] Pricing page loads: `https://yourdomain.com/pricing`
- [ ] Login page loads: `https://yourdomain.com/login`
- [ ] Signup page loads: `https://yourdomain.com/signup`

### Tool Pages

- [ ] Tools index: `https://yourdomain.com/tools`
- [ ] Mechanic checker: `https://yourdomain.com/tools/mechanic-quote-checker`
- [ ] At least 2 other tool pages load

### Guide Pages

- [ ] Guides index: `https://yourdomain.com/guides`
- [ ] At least 1 guide page loads

### Security (Should All Block)

- [ ] `/config/app.php` → Shows 403 Forbidden ✅
- [ ] `/composer.json` → Shows 403 Forbidden ✅
- [ ] `/src/Auth.php` → Shows 403 Forbidden ✅
- [ ] `/../config/app.php` → Shows 403 Forbidden ✅

### Authentication

- [ ] Can sign up for new account
- [ ] Receives 2 free credits
- [ ] Can log in with credentials
- [ ] Can log out
- [ ] Session persists across pages

### Quote Analysis

- [ ] Can access upload page when logged in
- [ ] Can select quote category (mechanic, plumber, etc.)
- [ ] Can enter ZIP code
- [ ] Can upload PDF or paste text
- [ ] Analysis processes without errors
- [ ] Result page shows:
  - [ ] Score (0-100)
  - [ ] Quoted price
  - [ ] Fair price range
  - [ ] Red flags or questions
- [ ] Credit deducted from account

### Payments

- [ ] Checkout page loads
- [ ] Can select single report ($4.99)
- [ ] Can select 3-pack ($11.99)
- [ ] Can select Pro plan ($19/month)
- [ ] Stripe checkout opens
- [ ] Can complete test purchase (use Stripe test card)
- [ ] Redirected back to site after payment
- [ ] Credits added to account
- [ ] Webhook processed successfully

---

## 🎨 DESIGN & RESPONSIVENESS

### Desktop

- [ ] Navigation menu works
- [ ] Hero animations play smoothly
- [ ] Stats counter animates on scroll
- [ ] Slider auto-plays
- [ ] All images load
- [ ] All fonts load (Inter)
- [ ] Favicon appears in browser tab

### Mobile

- [ ] Mobile menu opens/closes
- [ ] All pages are readable
- [ ] Buttons are tappable
- [ ] Forms are usable
- [ ] Slider swipes work
- [ ] Navigation is accessible
- [ ] Footer looks good

### Various Browsers

- [ ] Chrome/Edge
- [ ] Safari
- [ ] Firefox
- [ ] Mobile Safari (iPhone)
- [ ] Mobile Chrome (Android)

---

## 📊 SEO & META TAGS

- [ ] Each page has unique `<title>`
- [ ] Each page has meta description
- [ ] Favicon appears on all pages
- [ ] Open Graph tags present (check with Facebook debugger)
- [ ] Sitemap loads: `https://yourdomain.com/sitemap`
- [ ] Robots.txt loads: `https://yourdomain.com/robots.txt`
- [ ] Clean URLs work (no .php extensions)

---

## 💳 PAYMENT CONFIGURATION

### Stripe Dashboard

- [ ] Webhook URL set: `https://yourdomain.com/webhook`
- [ ] Webhook events selected:
  - [ ] `checkout.session.completed`
  - [ ] `invoice.payment_succeeded`
- [ ] Webhook signing secret copied to `config/app.php`
- [ ] Live mode activated (not test mode)
- [ ] Products created:
  - [ ] Single Report ($4.99)
  - [ ] 3-Report Pack ($11.99)
  - [ ] Pro Plan ($19/month recurring)
- [ ] Payment methods enabled (card, Google Pay, Apple Pay)

### Test Payments

- [ ] Test payment with Stripe test card
- [ ] Webhook triggered successfully
- [ ] Credits added to user account
- [ ] Email receipt sent (if enabled)
- [ ] Subscription created (for Pro plan)

---

## 🤖 API INTEGRATIONS

### OpenAI

- [ ] API key is valid
- [ ] Account has credits/billing set up
- [ ] Test quote analysis succeeds
- [ ] No rate limit errors
- [ ] Responses are reasonable

### Cloudflare Turnstile (Optional)

- [ ] Site created in Cloudflare
- [ ] Site key added to config
- [ ] Secret key added to config
- [ ] Turnstile widget appears on signup/login
- [ ] Bot protection works

---

## 📝 LOGS & MONITORING

- [ ] Error logs accessible: Hostinger Panel → Error Logs
- [ ] Application logs: `/storage/logs/app.log`
- [ ] Database queries not showing errors
- [ ] No PHP warnings or notices
- [ ] Session data saving correctly

---

## 🚨 TROUBLESHOOTING COMPLETED

If you encountered issues, verify you fixed:

- [ ] "500 Error" → Fixed .htaccess syntax
- [ ] "Database Error" → Fixed credentials in config
- [ ] "Clean URLs Not Working" → Verified mod_rewrite enabled
- [ ] "Upload Failing" → Set storage/uploads to 755
- [ ] "Stripe Error" → Updated webhook URL and keys
- [ ] "OpenAI Error" → Verified API key and billing

---

## 🎉 FINAL VERIFICATION

- [ ] Signed up as test user
- [ ] Analyzed 1 test quote successfully
- [ ] Purchased credits (or tested checkout)
- [ ] Logged out and logged back in
- [ ] Tested on mobile device
- [ ] Shared link with friend - they confirmed it works
- [ ] Checked performance (PageSpeed Insights)
- [ ] Checked security (SSL Labs)
- [ ] Bookmarked admin/dashboard URL
- [ ] Saved Hostinger login credentials securely
- [ ] Saved Stripe dashboard credentials
- [ ] Saved database credentials

---

## 📅 POST-LAUNCH TASKS

### Immediately After Launch

- [ ] Monitor error logs for first 24 hours
- [ ] Check user signups are working
- [ ] Verify webhook is processing payments
- [ ] Test from different devices/browsers
- [ ] Check Google Analytics (if installed)

### First Week

- [ ] Back up database
- [ ] Review user feedback
- [ ] Monitor server resources
- [ ] Check for any broken links
- [ ] Verify SEO indexing starting

### Ongoing

- [ ] Regular database backups (weekly)
- [ ] Monitor OpenAI usage/costs
- [ ] Review Stripe transactions
- [ ] Update Composer packages monthly
- [ ] Check security headers quarterly

---

## 🎯 CONGRATULATIONS!

If you checked all boxes, your site is LIVE and SECURE! 🚀

**Save this checklist** for future updates and troubleshooting.

---

**Need help?** Review:

- [DEPLOYMENT.md](DEPLOYMENT.md) - Full deployment guide
- [QUICK-REF.md](QUICK-REF.md) - Quick command reference
- [HOSTINGER-STRUCTURE.md](HOSTINGER-STRUCTURE.md) - Security explained

**Support:**

- Hostinger: Live chat in control panel
- Stripe: dashboard.stripe.com/support
- OpenAI: help.openai.com
