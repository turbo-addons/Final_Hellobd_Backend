<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Publish scheduled posts that are due';

    public function handle()
    {
        try {
            $count = Post::where('status', 'scheduled')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->update(['status' => 'published']);
            
            $this->info("Published {$count} scheduled posts.");
            
            if ($count > 0) {
                Log::info("Scheduled posts published", ['count' => $count]);
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('Failed to publish scheduled posts: ' . $e->getMessage());
            $this->error('Failed to publish scheduled posts: ' . $e->getMessage());
            return 1;
        }
    }
    

}