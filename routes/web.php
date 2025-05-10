<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ViewsController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::post('/view' , [VideoController::class , 'view'])->name('view');
Route::resource('/videos', VideoController::class);
Route::post('/like' , [LikeController::class , 'like'])->name('like');
Route::post('/comment' , [CommentController::class , 'comment'])->name('comment');
Route::get('/comment/edit/{comment}' , [CommentController::class , 'edit'])->name('comment.edit');
Route::patch('/comment/{comment}' , [CommentController::class , 'update'])->name('comment.update');
Route::delete('/comment/{comment}' , [CommentController::class , 'delete'])->name('comment.destroy');