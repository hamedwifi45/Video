<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MainController;
use App\Models\Comment;

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ViewsController;
use Psy\Command\HistoryCommand;



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
});
Route::get('/admin' , [AdminsController::class , 'index'])->name('admin.index');

Route::get('/' , [MainController::class , 'index'])->name('main');
Route::get('/main/{channel}/videos' , [MainController::class , 'ChannelsVideos'])->name('main.channels.videos');
Route::post('/view' , [VideoController::class , 'view'])->name('view');
Route::get('/video/search' , [VideoController::class , 'serch'])->name('video.search');
Route::resource('/videos', VideoController::class);
Route::post('/like' , [LikeController::class , 'like'])->name('like');
Route::post('/comment' , [CommentController::class , 'comment'])->name('comment');
Route::get('/comment/edit/{id}' , [CommentController::class , 'edit'])->name('comment.edit');
Route::patch('/comment/{comment}' , [CommentController::class , 'update'])->name('comment.update');
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
Route::get('/history' , [HistoryController::class , 'index'])->name('History');
Route::post('/history/deleteall' , [HistoryController::class , 'deleteAll'])->name('History.delete.all');
Route::post('/history/delete' , [HistoryController::class , 'delete'])->name('History.delete');
Route::get('/channel' , [ChannelController::class , 'index'])->name('channel.index');
Route::get('/channel/search' , [ChannelController::class , 'search'])->name('channel.search');