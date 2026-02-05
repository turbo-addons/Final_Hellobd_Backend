<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Carbon\Carbon;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Publish scheduled posts that are due';

    public function handle()
    {
        $count = Post::where('status', 'scheduled')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->update([
                'status' => 'published'
            ]);

        $this->info("Published {$count} scheduled posts.");

        return 0;
    }

}