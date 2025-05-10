<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth')->except(['show' , 'view']),
        ];
    }
    public function __construct(){
        $this->middleware();
     }

    public function comment(Request $request){
        // dd($request);
        $videoid = $request->videoId;
        $userComment = $request->comment;
        $video = Video::find($videoid);
        $comment = new Comment();
        $user = Auth::user();

        $comment->body = $userComment;
        $comment->user_id = $user->id;
        $comment->video_id = $video->id;
        $comment->save();

        $username = $user->name;
        $userImage = $user->profile_photo_url;
        $date = Carbon::now()->diffForHumans();
        $commentId = $comment->id;
        return response()->json([
            'body' => $comment->body,
            'user' => [
                'name' => $comment->user->name,
                'profile_photo_url' => $comment->user->profile_photo_url
            ]
        ]);
        }
    public function edit(Comment $comment){
        return view('comment.edit');
    }
    public function destroy(Comment $comment){
        dd($comment);
        $comment->delete();
        return back();
    }
    public function update(Comment $comment){
        
    }
}
