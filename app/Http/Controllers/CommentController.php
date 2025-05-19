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
            (new Middleware('auth'))->except(['show' , 'view']),
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
            'id' => $comment->id,
            'user' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'profile_photo_url' => $comment->user->profile_photo_url
            ]
        ]);
        }
    public function edit($id){
        $comment = Comment::where('id' , $id)->first();
        return view('edit.comment' , compact('comment'));
    }
    public function destroy(Comment $comment){
        // dd($comment);
        $comment->delete();
        return back()->with('success' , "تم العملية بنجاح وحذف التعليق");
    }
    public function update(Comment $comment , Request $request){
    $comment->body = $request->body;
    $comment->save();
    return redirect()->route('videosp.show' , $comment->video_id)->with('success','تمت العملية بنجاح وعدل تعليق');
}
}
