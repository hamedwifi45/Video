<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Carbon::today()->subDays(7);
        $title = 'الفيديوهات الاكثر مشاهدة هذا الاسبوع';
        $videos = Video::join('views' , 'videos.id' , '=' ,'views.video_id' )
                    ->orderBy('views.views_number' , 'desc')
                    ->where('videos.created_at' , '>=' , $data)
                    ->take(16)
                    ->get('videos.*');
        return view('main' , data: compact('videos' , 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ChannelsVideos(User $channel)
    {
        $videos = Video::where('user_id' , $channel->id)->get();
        $title = 'جميع الفيديوهات بقناة : ' . $channel->name;
        return view('videos.my-videos' , compact('title' , 'videos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
