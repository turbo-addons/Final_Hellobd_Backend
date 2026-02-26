# 🚀 START HERE - R2 CDN Setup

## English Instructions

### What You Need to Do (3 Simple Steps)

#### Step 1: Get R2.dev Public URL
1. Go to: https://dash.cloudflare.com
2. Click **R2** → **hellowbd** bucket → **Settings** tab
3. Find **Public Access** section
4. Click **"Allow Access"** or **"Enable R2.dev subdomain"**
5. Copy the URL (looks like: `https://pub-xxxxx.r2.dev`)

#### Step 2: Update .env File
Open your `.env` file and change these two lines:

```bash
# Change this line:
R2_PUBLIC_URL=https://cdn.hellobd.news
# To your R2.dev URL:
R2_PUBLIC_URL=https://pub-xxxxx.r2.dev

# Change this line:
MEDIA_DISK=public
# To:
MEDIA_DISK=r2
```

#### Step 3: Test It
Run these commands:
```bash
php show-media-status.php
php test-r2-cors.php
```

Then upload a new image and check if it shows in the modal!

---

## বাংলা নির্দেশনা (Bangla Instructions)

### আপনাকে কি করতে হবে (৩টি সহজ ধাপ)

#### ধাপ ১: R2.dev Public URL নিন
1. এখানে যান: https://dash.cloudflare.com
2. **R2** → **hellowbd** bucket → **Settings** tab এ ক্লিক করুন
3. **Public Access** section খুঁজুন
4. **"Allow Access"** বা **"Enable R2.dev subdomain"** এ ক্লিক করুন
5. URL টা কপি করুন (দেখতে এরকম: `https://pub-xxxxx.r2.dev`)

#### ধাপ ২: .env File Update করুন
আপনার `.env` file খুলে এই দুইটা লাইন পরিবর্তন করুন:

```bash
# এই লাইনটা:
R2_PUBLIC_URL=https://cdn.hellobd.news
# পরিবর্তন করে আপনার R2.dev URL দিন:
R2_PUBLIC_URL=https://pub-xxxxx.r2.dev

# এই লাইনটা:
MEDIA_DISK=public
# পরিবর্তন করে এটা করুন:
MEDIA_DISK=r2
```

#### ধাপ ৩: Test করুন
এই command গুলো run করুন:
```bash
php show-media-status.php
php test-r2-cors.php
```

এরপর একটা নতুন image upload করে দেখুন modal এ show করে কিনা!

---

## 📚 More Help?

- **English Guide**: Read `R2_SETUP_GUIDE.md`
- **Bangla Guide**: Read `R2_SETUP_BANGLA.md`
- **Quick Reference**: Read `QUICK_REFERENCE.md`
- **Full Details**: Read `IMPLEMENTATION_SUMMARY.md`

---

## ✅ What's Already Done

- ✅ R2 configuration complete
- ✅ Upload functionality working
- ✅ CORS fix applied
- ✅ Helper scripts created
- ✅ Documentation ready

## ⏳ What You Need to Do

- ⏳ Enable R2.dev public URL
- ⏳ Update .env file
- ⏳ Test it!

---

**Everything is ready! Just follow the 3 steps above and you're done!**

**সব কিছু ready! শুধু উপরের ৩টা ধাপ follow করুন!**
