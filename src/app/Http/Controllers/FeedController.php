<?php

namespace App\Http\Controllers;
use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeds = Feed::orderBy('id','desc')->paginate(5);
        return view('feed.index', compact('feeds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feed.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url|unique:feeds',
            'update_frequency_second' => 'required|integer',
            'status' => 'required|integer',
        ]);

        Feed::create($request->post());

        return redirect()->route('feed.index')->with('success','Feed has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function show(Feed $feed)
    {
        return view('feed.show',compact('feed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function edit(Feed $feed)
    {
        return view('feed.edit',compact('feed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feed $feed)
    {
        $request->validate([
            'name' => 'required',
            'update_frequency_second' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $feed->fill($request->post())->save();

        return redirect()->route('feed.index')->with('success','Feed Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feed $feed)
    {
        $feed->delete();
        return redirect()->route('feed.index')->with('success','Feed has been deleted successfully');
    }
}
