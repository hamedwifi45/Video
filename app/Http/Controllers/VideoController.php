<?php

namespace App\Http\Controllers;
use FFMpeg\Format\Video\X264;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Coordinate\Dimension;
// use ProtoneMedia\LaravelFFMpeg\Support\Acc;
use Illuminate\Http\Request;


use App\Jobs\ConvertedVideoForStreaming;
use App\Models\ConvertedVideos;
use App\Models\Like;
use App\Models\Views;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            (new Middleware('auth'))->except(['show', 'view']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
       $this->middleware();
    }
    public function index()
    {
        $videos = auth()->user()->videos()->get()->sortByDesc('created_at');
        $title = 'اخر الفيديوهات المرفوعة';
        return view('videos.my-videos' , compact('videos' , 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videos.uploader');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'video' => 'required|file',
    ]);

    $randompath = Str::random(16);
    $manager = new ImageManager(new Driver());

    // إنشاء مسار الفيديو مع تضمين المجلد "videos"
    $videopath = $randompath . '.' . $request->video->getClientOriginalExtension();
    $imagepath = 'images/' . $randompath . '.' . $request->image->getClientOriginalExtension();

    // حفظ الفيديو في المجلد "videos"
    $request->video->storeAs("videos", $videopath, 'public'); // إزالة "/" الزائدة من بداية المسار
    $image = $manager->read($request->image)->resize(320, 180);

    $path = Storage::put($imagepath, $image->encode());

    // حفظ المسار الكامل (مع المجلد "videos") في قاعدة البيانات
    $video = Video::create([
        'disk' => 'public',
        'video_path' => 'videos/' . $videopath, // إضافة المجلد "videos" إلى المسار
        'title' => $request->title,
        'image_path' => $imagepath,
        'user_id' => auth()->id(),
    ]);
    
    $view = Views::create([
        'video_id' => $video->id,
        'user_id' => auth()->id(),
        'views_number' => 0
    ]);
    ConvertedVideoForStreaming::dispatch($video);
    
    return redirect()->back()->with('success', 'لقد رفع مقطعك بسلام انتظر فترة قصيرة حتى يتم معالجته');
}

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {   
            $videos = Video::where('user_id' , $video->user_id)->take(4)->get();
        $videosCount = Video::where('id' , $video->user_id)->count();
        if($videosCount > 4){
            $videos = Video::where('user_id' , $video->user_id)->take(4)->get();
            $videosAll = Video::take(10 - $videosCount)->get();
            $videos = $videos->merge($videosAll)->shuffle();
        }else{
            $videos = Video::where('user_id' , $video->user_id)->take($videosCount)->get();
            $videosAll = Video::take(10 - $videosCount)->get();
            $videos = $videos->merge($videosAll)->shuffle();
        }

        $countlike = Like::where('video_id' , $video->id)->where('Like' , 1)->count();
        $countDislike = Like::where('video_id' , $video->id)->where('Like' , 0)->count();
        $user = Auth::user();
        if(Auth::check()){
            auth()->user()->VideoInHistory()->attach($video->id);
            $userLike = $user->likes()->where('video_id' , $video->id)->first();
        }else{
            $userLike = 0;
        }
        $comments = $video->comments->sortByDesc('created_at');
        return view('videos.show-video' , compact('video','videos','comments', 'countlike', 'countDislike','userLike'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::where('id' , $id)->first();
        return view('videos.edit-video', compact('video'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $manger = new ImageManager(new Driver());
        $randompath = Str::random(16);
        $video = Video::where('id' , $id)->first();
        $request->validate(['title' => 'required']);
        $video->title = $request->title;
        if ($request->has('image')){
            $imagepath = 'images/' . $randompath . '.' . $request->image->getClientOriginalExtension();
            Storage::delete($video->image_path);
            $image = $manger->read($request->image)->resize(320 , 180);
            $path = Storage::put($imagepath , $image->encode());
            $video->image_path = $imagepath;
        }
        $video->save();
        return redirect('/videos')->with(
            'success',
            'تم تعديل معلومات الفيديو بنجاح'
        );    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::where('id' , $id)->first();
        $convertedVideos = ConvertedVideos::where('video_id' , $id)->get();
        foreach($convertedVideos as $convert){
            Storage::delete([
                $convert->mp4_Format_240,
                $convert->mp4_Format_360,
                $convert->mp4_Format_480,
                $convert->mp4_Format_720,
                $convert->mp4_Format_1080,
                $convert->webm_Format_240,
                $convert->webm_Format_360,
                $convert->webm_Format_480,
                $convert->webm_Format_720,
                $convert->webm_Format_1080,
                $video->image_path
            ]);
        }

        $video->delete();

        return back()->with('success', ' تم حذف الفيديو بنجاح');
    }
    public function view(Request $request){
        $view = Views::where('video_id' , $request->videoId)->first();
        // dd([$view , $request->videoId]);
        // $view = $view->views_number++;
        // $view->save();
        // كود مختصر
        $view->increment('views_number');
        $viewsnum = $view->views_number;
        return response()->json(['views' => $viewsnum]);
    }
    public function serch(Request $request){
        $videos = auth()->user()->videos()->where('title' , 'like' ,'%'. $request->title . '%')->get()->sortByDesc('created_at');
        $title = 'اخر الفيديوهات المرفوعة';
        return view('videos.my-videos' , compact('videos' , 'title'));
    
    }
}
