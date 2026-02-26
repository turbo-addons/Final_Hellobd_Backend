<?php

/**
 * Test R2 CORS Configuration
 * 
 * This script tests if your R2 public URL has CORS headers enabled.
 * Run: php test-r2-cors.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing R2 CORS Configuration...\n";
echo str_repeat('=', 50) . "\n\n";

// Get R2 configuration
$r2PublicUrl = config('filesystems.disks.r2.url');
$r2Bucket = config('filesystems.disks.r2.bucket');
$mediaDisk = config('media-library.disk_name');

echo "Current Configuration:\n";
echo "  Media Disk: {$mediaDisk}\n";
echo "  R2 Bucket: {$r2Bucket}\n";
echo "  R2 Public URL: {$r2PublicUrl}\n\n";

// Check if using R2
if ($mediaDisk !== 'r2') {
    echo "⚠️  WARNING: Media disk is set to '{$mediaDisk}', not 'r2'\n";
    echo "   To use R2, set MEDIA_DISK=r2 in your .env file\n\n";
}

// Check if R2 public URL is configured
if (empty($r2PublicUrl)) {
    echo "❌ ERROR: R2_PUBLIC_URL is not configured in .env\n";
    echo "   Please add your R2.dev public URL\n";
    exit(1);
}

// Check if using custom domain (won't have CORS)
if (strpos($r2PublicUrl, '.r2.dev') === false) {
    echo "⚠️  WARNING: You're using a custom domain: {$r2PublicUrl}\n";
    echo "   Custom domains don't support CORS without Cloudflare Workers\n";
    echo "   Recommended: Use R2.dev public URL instead\n\n";
}

// Test CORS by checking headers
echo "Testing CORS headers...\n";

// Get latest media file to test
$latestMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::latest()->first();

if (!$latestMedia) {
    echo "⚠️  No media files found. Upload a file first to test.\n";
    exit(0);
}

$testUrl = '';
try {
    if ($latestMedia->disk === 'r2') {
        $testUrl = $r2PublicUrl . '/' . $latestMedia->id . '/' . $latestMedia->file_name;
    } else {
        $testUrl = $latestMedia->getUrl();
    }
} catch (Exception $e) {
    $testUrl = $r2PublicUrl . '/' . $latestMedia->id . '/' . $latestMedia->file_name;
}

echo "  Test URL: {$testUrl}\n";

// Make HTTP request to check CORS headers
$ch = curl_init($testUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Origin: http://localhost:8000',
    'Access-Control-Request-Method: GET',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  HTTP Status: {$httpCode}\n";

// Parse headers
$headers = [];
$headerLines = explode("\n", $response);
foreach ($headerLines as $line) {
    if (strpos($line, ':') !== false) {
        list($key, $value) = explode(':', $line, 2);
        $headers[strtolower(trim($key))] = trim($value);
    }
}

// Check for CORS headers
$hasCors = false;
$corsHeaders = [
    'access-control-allow-origin',
    'access-control-allow-methods',
    'access-control-allow-headers',
];

echo "\nCORS Headers:\n";
foreach ($corsHeaders as $header) {
    if (isset($headers[$header])) {
        echo "  ✅ {$header}: {$headers[$header]}\n";
        $hasCors = true;
    } else {
        echo "  ❌ {$header}: NOT FOUND\n";
    }
}

echo "\n" . str_repeat('=', 50) . "\n";

if ($hasCors) {
    echo "✅ SUCCESS! CORS headers are present.\n";
    echo "   Images should load in modal without 403 errors.\n";
} else {
    echo "❌ FAILED! No CORS headers found.\n";
    echo "\nSolutions:\n";
    echo "  1. Enable R2.dev public URL in Cloudflare dashboard\n";
    echo "  2. Update R2_PUBLIC_URL in .env to use R2.dev URL\n";
    echo "  3. Or setup Cloudflare Workers for custom domain\n";
}

echo "\n";
