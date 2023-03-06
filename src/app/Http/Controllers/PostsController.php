<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessParseUrls;
use App\Models\Feed;
use App\Models\Posts;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $post)
    {
        return view('posts.view',compact('post'));
    }

    public function parse()
    {
        // Select feeds from Feed table where status = active
        $feeds = Feed::where('status', Feed::STATUS_ACTIVE)
            ->select('url','updated_at')
            ->get();

        // If feeds is empty return
        if ($feeds->isEmpty()) {
            return redirect()->route('posts.index')->with('error','No feeds to parse.');
        }

        // Get feeds url array
        $feedsUrlArray = $feeds->pluck('url')->toArray();
        // Get feeds updated_at array
        $feedsUpdatedAtArray = $feeds->pluck('updated_at','url')->toArray();

        ProcessParseUrls::dispatch($feedsUrlArray, $feedsUpdatedAtArray);

        return redirect()->route('posts.index')->with('success','Posts added to queue successfully.');
    }

}
