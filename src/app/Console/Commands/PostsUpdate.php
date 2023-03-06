<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Models\Posts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PostsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update posts from feeds';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating posts from feeds...');
        $this->info('Done!');
        return Command::SUCCESS;
    }
}
