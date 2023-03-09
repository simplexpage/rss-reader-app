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
        'last_update',
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
    public static function parseUrls($feedsUrlArray)
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
        $urls = array_keys($feedsUrlArray);
        // feedsArray to json { "urls": ["url1", "url2"] }
        $feedsJson = json_encode(['urls' => $urls]);
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
        $feedsUrlUpdateArray = $feedsUrlArray;
        // Save response to Posts table
        foreach ($response['data']['items'] as $item) {
            $isUpdate = false;
            $feedLastUpdate = $feedsUrlArray[$item['source_url']];
            if ($feedLastUpdate == null) {
                $isUpdate = true;
                if ($feedsUrlUpdateArray[$item['source_url']] == null) {
                    $feedsUrlUpdateArray[$item['source_url']] = $item['publish_date'];
                } else {
                    if ($item['publish_date'] > $feedsUrlUpdateArray[$item['source_url']]) {
                        $feedsUrlUpdateArray[$item['source_url']] = $item['publish_date'];
                    }
                }
            } else {
                if ($item['publish_date'] > $feedLastUpdate) {
                    $isUpdate = true;
                    if ($item['publish_date'] > $feedsUrlUpdateArray[$item['source_url']]) {
                        $feedsUrlUpdateArray[$item['source_url']] = $item['publish_date'];
                    }
                }
            }
            if ($isUpdate) {
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
        // Update feeds last_update
        foreach ($feedsUrlUpdateArray as $url => $lastUpdate) {
            Feed::where('url', $url)
                ->update(['last_update' => $lastUpdate]);
        }
        $infoArray['status'] = 'success';
        $infoArray['message'] = 'Feeds parsed successfully.';
        return $infoArray;
    }
}
