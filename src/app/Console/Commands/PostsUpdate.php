<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
