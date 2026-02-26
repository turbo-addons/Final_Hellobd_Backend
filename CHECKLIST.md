# ✅ R2 CDN Setup Checklist

## What's Already Done ✅

- [x] R2 disk configuration added to `config/filesystems.php`
- [x] Media library configured to use R2 in `config/media-library.php`
- [x] R2 credentials added to `.env` file
- [x] Upload functionality modified in `MediaLibraryService.php`
- [x] Post image uploads updated in `PostController.php`
- [x] URL generation fixed in `MediaController.php`
- [x] CORS fix applied to media modal (crossorigin attribute)
- [x] Helper scripts created (4 scripts)
- [x] Documentation created (6 files)
- [x] AWS S3 package installed (`league/flysystem-aws-s3-v3`)

## What You Need to Do ⏳

### Step 1: Enable R2.dev Public URL
- [ ] Go to Cloudflare Dashboard: https://dash.cloudflare.com
- [ ] Navigate to: R2 → hellowbd bucket → Settings tab
- [ ] Find "Public Access" section
- [ ] Click "Allow Access" or "Enable R2.dev subdomain"
- [ ] Copy the R2.dev URL (format: `https://pub-xxxxx.r2.dev`)

### Step 2: Update .env File
- [ ] Open `.env` file in your project root
- [ ] Find line: `R2_PUBLIC_URL=https://cdn.hellobd.news`
- [ ] Replace with: `R2_PUBLIC_URL=https://pub-xxxxx.r2.dev` (your actual URL)
- [ ] Find line: `MEDIA_DISK=public`
- [ ] Change to: `MEDIA_DISK=r2`
- [ ] Save the file

### Step 3: Test the Setup
- [ ] Run: `php show-media-status.php` (check current media files)
- [ ] Run: `php test-r2-cors.php` (verify CORS headers)
- [ ] Upload a new image via admin panel
- [ ] Check if image shows in media modal without 403 error
- [ ] Verify image URL starts with your R2.dev domain

### Step 4: Verify Everything Works
- [ ] Upload multiple images
- [ ] Check images in media library
- [ ] Create a new post with images
- [ ] View post on frontend
- [ ] Check browser console for errors
- [ ] Verify no 403 Forbidden errors

## Optional: Migrate Old Files to R2

If you want to move existing local files to R2:
- [ ] Backup your local storage files
- [ ] Create migration script (if needed)
- [ ] Test with a few files first
- [ ] Migrate all files
- [ ] Update database URLs

## Testing Commands Reference

```bash
# Check media files status and location
php show-media-status.php

# Test CORS headers on R2 URLs
php test-r2-cors.php

# Check latest uploaded media
php check-latest-media.php

# Test R2 connection and upload
php test-r2-upload.php
```

## Documentation Reference

- **Quick Start**: `START_HERE.md`
- **English Guide**: `R2_SETUP_GUIDE.md`
- **Bangla Guide**: `R2_SETUP_BANGLA.md`
- **Quick Reference**: `QUICK_REFERENCE.md`
- **Technical Details**: `IMPLEMENTATION_SUMMARY.md`
- **Visual Diagram**: `SETUP_DIAGRAM.txt`
- **This Checklist**: `CHECKLIST.md`

## Troubleshooting

### If images show 403 error:
1. Check if R2.dev URL is set in `.env`
2. Run `php test-r2-cors.php` to verify CORS
3. Make sure you're using R2.dev URL, not custom domain
4. Clear browser cache and try again

### If files upload to local storage:
1. Check `.env` has `MEDIA_DISK=r2`
2. Run `php show-media-status.php` to see current disk
3. Restart your web server after changing `.env`

### If CORS test fails:
1. Verify R2.dev public URL is enabled in Cloudflare
2. Check the URL in `.env` is correct
3. Make sure URL starts with `https://pub-` and ends with `.r2.dev`

## Success Criteria ✅

You'll know everything is working when:
- ✅ New images upload to R2 (check Cloudflare dashboard)
- ✅ Images show in media modal without errors
- ✅ Image URLs start with your R2.dev domain
- ✅ No 403 Forbidden errors in browser console
- ✅ `php test-r2-cors.php` shows CORS headers present
- ✅ `php show-media-status.php` shows files on R2 disk

## Need Help?

If you encounter any issues:
1. Check the documentation files listed above
2. Run the helper scripts to diagnose
3. Check browser console for specific errors
4. Verify all checklist items are completed

---

**Current Status**: Implementation Complete - Waiting for R2.dev URL

**Next Action**: Enable R2.dev public URL in Cloudflare and update .env
