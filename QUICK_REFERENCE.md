# Quick Reference - R2 Setup

## Current Status
- ✅ R2 configuration complete
- ✅ Upload functionality working
- ✅ Files uploading to R2 successfully
- ✅ CORS fix added to modal
- ⏳ Waiting for R2.dev public URL

## What You Need to Do

### 1. Get R2.dev Public URL
Go to: Cloudflare Dashboard → R2 → hellowbd bucket → Settings → Enable Public Access

### 2. Update .env
```bash
# Replace this:
R2_PUBLIC_URL=https://cdn.hellobd.news

# With your R2.dev URL:
R2_PUBLIC_URL=https://pub-xxxxx.r2.dev

# And change:
MEDIA_DISK=r2
```

### 3. Test
```bash
php show-media-status.php
php test-r2-cors.php
```

## Commands Reference

```bash
# Check media files status
php show-media-status.php

# Test CORS headers
php test-r2-cors.php

# Check latest uploaded media
php check-latest-media.php

# Test R2 connection
php test-r2-upload.php
```

## Files Modified
- `.env` - R2 config ready
- `config/filesystems.php` - R2 disk added
- `config/media-library.php` - R2 as default
- `app/Services/MediaLibraryService.php` - Upload to R2
- `app/Http/Controllers/Backend/MediaController.php` - R2 URLs
- `app/Http/Controllers/Backend/PostController.php` - Post images to R2
- `resources/views/components/media-modal.blade.php` - CORS fix

## Why R2.dev URL?
- ✅ Has CORS enabled by default
- ✅ No Workers needed
- ✅ Free and instant
- ✅ Works perfectly as CDN
- ❌ Custom domain needs Workers (complex)

## Troubleshooting

### Images not showing in modal?
1. Check if R2.dev URL is set in .env
2. Run: `php test-r2-cors.php`
3. Check browser console for errors

### Files not uploading?
1. Check: `php show-media-status.php`
2. Verify MEDIA_DISK=r2 in .env
3. Check R2 credentials

### 403 Forbidden error?
- Using custom domain? → Switch to R2.dev URL
- CORS not enabled? → Run `php test-r2-cors.php`

## Support Files
- `R2_SETUP_GUIDE.md` - Detailed English guide
- `R2_SETUP_BANGLA.md` - Bangla guide (বাংলা গাইড)
- `QUICK_REFERENCE.md` - This file

---

**Everything is ready! Just enable R2.dev public URL and update .env**
