<?php

// Controllers
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ChannelController;
use Illuminate\Support\Facades\Route;

// ------------------------------------------------------------------
// المسارات التي تتطلب تسجيل الدخول
// ------------------------------------------------------------------
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // مسارات الإدارة
    Route::prefix('/admin')->middleware("can:updateVid")->group(function(){
        Route::get('/', [AdminsController::class, 'index'])->name('admin.index');
        Route::get('/channels', action: [AdminsController::class, 'channels'])->name('channels.index');
        Route::get('/channels/all', action: [AdminsController::class, 'Allchannels'])->name('channels');
        Route::patch('/{user}/channels', action: [AdminsController::class, 'adminUpdate'])->name('channels.update')->middleware('can:updateUser');
        Route::delete('/{user}/channels/delete', action: [AdminsController::class, 'admindelete'])->name('channels.delete')->middleware('can:updateUser');
        Route::patch('/{user}/channels/delete', action: [AdminsController::class, 'adminBlock'])->name('channels.block')->middleware('can:updateVid');
        Route::get('/channels/block', action: [AdminsController::class, 'block'])->name('channels.block')->middleware('can:updateUser');
        Route::patch('/channels/block/{user}', action: [AdminsController::class, 'unblock'])->name('channels.block.edit');
        Route::get('/Videos/Top', action: [AdminsController::class, 'TopVideos'])->name('TopVideos');

    });        

    // تعليقات - تعديل / حذف / تحديث
    Route::post('/comment', [CommentController::class, 'comment'])->name('comment');
    Route::get('/comment/edit/{id}', [CommentController::class, 'edit'])->name('comment.edit');
    Route::patch('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // سجل المشاهدات
    Route::get('/history', [HistoryController::class, 'index'])->name('History');
    Route::post('/history/deleteall', [HistoryController::class, 'deleteAll'])->name('History.delete.all');
    Route::post('/history/delete', [HistoryController::class, 'delete'])->name('History.delete');

    
    // عمليات على الفيديوهات (باستثناء show)
    Route::resource('/videos', VideoController::class)->except(['show']);

    // مشاهدة الفيديو
    Route::post('/view', [VideoController::class, 'view'])->name('view');
});

// ------------------------------------------------------------------
// المسارات المتاحة للجميع (بدون تسجيل دخول)
// ------------------------------------------------------------------
Route::get('/', [MainController::class, 'index'])->name('main');
// القنوات
Route::get('/channel', [ChannelController::class, 'index'])->name('channel.index');
Route::get('/channel/search', [ChannelController::class, 'search'])->name('channel.search');
Route::get('/main/{channel}/videos', [MainController::class, 'ChannelsVideos'])->name('main.channels.videos');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show'); // <-- السماح بعرض الفيديو
Route::get('/video/search', [VideoController::class, 'search'])->name('video.search');
Route::post('/like', [LikeController::class, 'like'])->name('like');
