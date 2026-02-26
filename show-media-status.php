<?php

/**
 * Show Media Files Status
 * 
 * This script shows all media files and which storage disk they're on.
 * Run: php show-media-status.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Media Files Status Report\n";
echo str_repeat('=', 80) . "\n\n";

// Get configuration
$currentDisk = config('media-library.disk_name');
$r2PublicUrl = config('filesystems.disks.r2.url');
$localPublicUrl = config('filesystems.disks.public.url');

echo "Current Configuration:\n";
echo "  Active Disk: {$currentDisk}\n";
echo "  Local URL: {$localPublicUrl}\n";
echo "  R2 URL: {$r2PublicUrl}\n\n";

// Get all media files
$allMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::orderBy('created_at', 'desc')->get();
$totalCount = $allMedia->count();

if ($totalCount === 0) {
    echo "No media files found.\n";
    exit(0);
}

// Count by disk
$diskCounts = $allMedia->groupBy('disk')->map->count();

echo "Total Media Files: {$totalCount}\n";
echo "Files by Storage:\n";
foreach ($diskCounts as $disk => $count) {
    $diskName = $disk ?: 'public';
    echo "  - {$diskName}: {$count} files\n";
}

echo "\n" . str_repeat('-', 80) . "\n";
echo "Latest 10 Files:\n";
echo str_repeat('-', 80) . "\n\n";

// Show latest 10 files
$latestMedia = $allMedia->take(10);

foreach ($latestMedia as $media) {
    $disk = $media->disk ?: 'public';
    $size = number_format($media->size / 1024, 2);
    $date = $media->created_at->format('Y-m-d H:i:s');
    
    // Generate URL
    $url = '';
    try {
        $url = $media->getUrl();
    } catch (Exception $e) {
        if ($disk === 'r2') {
            $url = $r2PublicUrl . '/' . $media->id . '/' . $media->file_name;
        } else {
            $url = $localPublicUrl . '/' . $media->id . '/' . $media->file_name;
        }
    }
    
    echo "ID: {$media->id}\n";
    echo "  Name: {$media->file_name}\n";
    echo "  Disk: {$disk}\n";
    echo "  Size: {$size} KB\n";
    echo "  Date: {$date}\n";
    echo "  URL: {$url}\n";
    
    // Check if file is accessible
    if ($disk === 'r2') {
        echo "  Storage: ☁️  Cloudflare R2\n";
    } else {
        echo "  Storage: 💾 Local Storage\n";
    }
    
    echo "\n";
}

echo str_repeat('=', 80) . "\n";

// Recommendations
if ($currentDisk === 'public' && $diskCounts->has('r2')) {
    echo "\n⚠️  NOTICE:\n";
    echo "  You have files on R2 but current disk is set to 'public'\n";
    echo "  New uploads will go to local storage.\n";
    echo "  To use R2, set MEDIA_DISK=r2 in .env\n";
} elseif ($currentDisk === 'r2' && $diskCounts->has('public')) {
    echo "\n✅ GOOD:\n";
    echo "  Current disk is R2. New uploads will go to R2.\n";
    echo "  You have {$diskCounts['public']} old files on local storage.\n";
} elseif ($currentDisk === 'r2') {
    echo "\n✅ PERFECT:\n";
    echo "  All files are on R2 and new uploads will go to R2.\n";
} else {
    echo "\n💾 LOCAL STORAGE:\n";
    echo "  All files are on local storage.\n";
    echo "  To use R2, set MEDIA_DISK=r2 in .env\n";
}

echo "\n";
