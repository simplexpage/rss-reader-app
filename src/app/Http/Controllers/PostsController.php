<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Posts;
use Illuminate\Support\Facades\Http;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::orderBy('id','desc')->paginate(20);
        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $post)
    {
        return view('posts.show',compact('post'));
    }

    public function parse()
    {
        // Select array of urls from Feed table
        $feedsArray = Feed::where('status', Feed::STATUS_ACTIVE)->get()->pluck('url')->toArray();
        // feedsArray to json { "urls": ["url1", "url2"] }
        $feedsJson = json_encode(['urls' => $feedsArray]);
        // Create post request json to parse feeds from url
        $request = Http::withBody($feedsJson, 'application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('http://go_rss_reader:8082/reader/parse');
        // Get status code from parse feeds
        if ($request->status() != 200) {
            return redirect()->route('posts.index')->with('error','Error while updating posts from feeds.');
        }
        // Get response from parse feeds
        $response = json_decode($request->getBody()->getContents(), true);
        if (empty($response['data']['items'])) {
            return redirect()->route('posts.index')->with('success','Posts has been updated successfully.');
        }
        // Save response to Posts table
        foreach ($response['data']['items'] as $item) {
            Posts::create([
                'title' => strip_tags($item['title']),
                'source' => $item['source'],
                'source_url' => $item['source_url'],
                'description' => strip_tags($item['description']),
                'link' => $item['link'],
                'pub_date' => $item['publish_date'],
            ]);
        }
        return redirect()->route('posts.index')->with('success','Posts has been updated successfully.');
    }

}
