<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HistoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }
    public function __construct(){
        $this->middleware();
    }
    public function index(){
        $user = User::find(auth()->user()->id);
        $videos = $user->VideoInHistory()->get();
        $title = 'سجل المشاهدة';
        return view('history.history-index', compact('title' , 'videos'));
    }
    public function deleteAll(){
        $user = User::find(auth()->user()->id);
        $user->VideoInHistory()->detach();
        $videos = $user->VideoInHistory()->get();
        $title = 'سجل المشاهدة';
        return view('history.history-index', compact('title' , 'videos'));
    }
    public function delete(Video $video){
        $user = User::find(auth()->user()->id);
        $user->VideoInHistory()->detach($video->id);
        $videos = $user->VideoInHistory()->get();
        $title = 'سجل المشاهدة';
        return view('history.history-index', compact('title' , 'videos'));
    }
}
