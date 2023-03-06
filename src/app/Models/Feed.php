<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Feed extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'status',
    ];

    public static function getArrrayStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public function getStatus()
    {
        $status = self::getArrrayStatus();
        return $status[$this->status];
    }

    // Parse feeds from urls
    public static function parseUrls($feedsUrlArray, $feedsUpdatedAtArray)
    {
        $infoArray = [
            'status' => 'error',
            'message' => 'Error parse feeds.',
        ];
        // Check if $feedsUrlArray is empty
        if (empty($feedsUrlArray)) {
            $infoArray['message'] = 'Empty url feeds array.';
            return $infoArray;
        }
        // Check if feedsUpdatedAtArray is empty
        if (empty($feedsUpdatedAtArray)) {
            $infoArray['message'] = 'Empty feeds array.';
            return $infoArray;
        }
        // feedsArray to json { "urls": ["url1", "url2"] }
        $feedsJson = json_encode(['urls' => $feedsUrlArray]);
        // Create post request json to parse feeds from url
        $request = Http::withBody($feedsJson, 'application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(Config::get('app.parser_reader_url'));
        // Get status code from parse feeds
        if ($request->status() != 200) {
            $infoArray['message'] = 'Error parse feeds.';
            return $infoArray;
        }
        // Get response from parse feeds
        $response = json_decode($request->getBody()->getContents(), true);
        if (empty($response['data']['items'])) {
            $infoArray['message'] = 'Empty response from parse feeds.';
            return $infoArray;
        }
        // Save response to Posts table
        foreach ($response['data']['items'] as $item) {
            if ($feedUpdateAt = $feedsUpdatedAtArray[$item['source_url']]) {
                if ($item['publish_date'] > $feedUpdateAt->toDateTimeString()) {
                    Posts::create([
                        'title' => $item['title'],
                        'source' => $item['source'],
                        'source_url' => $item['source_url'],
                        'description' => $item['description'],
                        'link' => $item['link'],
                        'pub_date' => $item['publish_date'],
                    ]);
                }
            }
        }
        $infoArray['status'] = 'success';
        $infoArray['message'] = 'Feeds parsed successfully.';
        return $infoArray;
    }
}
