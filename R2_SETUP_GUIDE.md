# Cloudflare R2 Setup Guide - Simple Solution

## Problem
- Images upload to R2 successfully ✅
- Images open directly in browser ✅  
- Images show 403 error in modal ❌
- Reason: Custom domain `cdn.hellobd.news` doesn't send CORS headers

## Simple Solution (No Workers Needed!)

### Step 1: Enable R2.dev Public URL
1. Go to: https://dash.cloudflare.com
2. Click on **R2** in left sidebar
3. Click on your bucket: **hellowbd**
4. Click **Settings** tab
5. Find **Public Access** section
6. Click **"Allow Access"** or **"Enable R2.dev subdomain"**
7. Copy the public URL (looks like: `https://pub-xxxxx.r2.dev`)

### Step 2: Update .env File
Replace this line in your `.env`:
```
R2_PUBLIC_URL=https://cdn.hellobd.news
```

With your R2.dev URL:
```
R2_PUBLIC_URL=https://pub-xxxxx.r2.dev
```

And change:
```
MEDIA_DISK=public
```

To:
```
MEDIA_DISK=r2
```

### Step 3: Test
1. Upload a new image
2. Check if it shows in the modal without 403 error
3. R2.dev URLs have CORS enabled by default!

## Why This Works
- R2.dev subdomain automatically sends CORS headers
- Custom domains (cdn.hellobd.news) don't send CORS headers
- R2.dev is free and works immediately
- No Cloudflare Workers setup needed

## Current Status
- ✅ R2 configuration done
- ✅ Upload functionality working
- ✅ Files stored in R2
- ⏳ Waiting for R2.dev public URL from you

## Alternative (If You Want Custom Domain)
If you really need `cdn.hellobd.news`, you MUST setup Cloudflare Workers.
But R2.dev URL is simpler and works perfectly!

---

**Note**: R2.dev URLs are public and cacheable, perfect for CDN use.
