<?php

namespace App\Jobs;

use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessParseUrls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $feedsUrlArray;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($feedsUrlArray)
    {
        $this->feedsUrlArray = $feedsUrlArray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Feed::parseUrls($this->feedsUrlArray);
    }
}
