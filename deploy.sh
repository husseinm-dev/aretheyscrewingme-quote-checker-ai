#!/bin/bash

# Quick Deploy Script for Hostinger
# Run this after making changes to prepare files for upload

echo "🚀 Building for Hostinger deployment..."
echo ""

# Check if node_modules exists
if [ ! -d "node_modules" ]; then
    echo "📦 Installing Node dependencies..."
    npm install
fi

# Run gulp build
echo "⚙️  Running Gulp build..."
npm run deploy

echo ""
echo "✅ Build complete!"
echo ""
echo "📁 Files ready in: hostinger/"
echo ""
echo "📤 Next steps:"
echo "  1. Open FileZilla/FTP client"
echo "  2. Upload hostinger/public_html/* to your Hostinger public_html/"
echo "  3. Upload hostinger/config/, src/, vendor/ to parent directory"
echo "  4. Clear browser cache and test your site"
echo ""
echo "🎯 To upload specific files:"
echo "  - CSS: hostinger/public_html/assets/css/app.css"
echo "  - JS: hostinger/public_html/assets/js/*.js"
echo "  - PHP: hostinger/public_html/*.php"
echo ""
