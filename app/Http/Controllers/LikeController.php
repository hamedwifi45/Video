<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }
    public function like(Request $request)
    {
        $videoId = $request->videoId;
        $isLike = filter_var($request->isLike, FILTER_VALIDATE_BOOLEAN);
        $update = false;

        $video = Video::find($videoId);
        if (!$video) {
            return null;
        }

        $user = Auth::user();
        $like = $user->likes()->where('video_id', $videoId)->first();


        if ($like) {
            $alreadyLike = $like->Like;
            $update = true;
            // dd($like);
            // dd($isLike);
            if ($alreadyLike == $isLike) {
                $like->delete();
            }
        } else {
            $like = new Like();
        }

        $like->like = $isLike;
        $like->user_id = $user->id;
        $like->video_id = $video->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }

        $countLike = Like::where('video_id', $video->id)->where('like', '1')->count();
        $countDislike = Like::where('video_id', $video->id)->where('like', '0')->count();

        return response()->json(['countlike' => $countLike, 'countDislike' => $countDislike]);
    }
}
