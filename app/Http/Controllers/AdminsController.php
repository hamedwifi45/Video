<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Views;
use DB;
use Illuminate\Http\Request;
// use View;

class AdminsController extends Controller
{
    public function index(){
        $videosCount = Video::count();
        $channelsCount = User::count();
        $mostView = Views::select('user_id' , DB::raw('sum(views.views_number)as total'))
        ->groupBy('user_id')
        ->orderBy('total' , 'desc')->take(5)->get();
        // dd($mostView);
        $names = [];
        $totleView = [];
        foreach ($mostView as $helo) {
            array_push($names , User::find($helo->user_id)->name );
            array_push($totleView , $helo->total );
        }
        // dd($totleView , $names);
        return view('admin.index' , compact('videosCount'  , 'channelsCount'))->with('names' ,json_encode($names , JSON_NUMERIC_CHECK) )->with('total' ,json_encode($totleView , JSON_NUMERIC_CHECK) );
    }
    public function channels(){
        $users = User::all();
        return view('admin.channels' ,compact('users'));
    }
    public function adminUpdate(Request $request , User $user){
        $user->admin_level = $request->admin_level;
        $user->save();
        session()->flash('flash_message' , 'تمت العملية ياض');
        return back();
    }
    public function admindelete(User $user){
        $user->delete();
        session()->flash('flash_message' , 'حذف البشري تمت العملية ياض');
        return back();
    }
    public function adminBlock(User $user){
        $user->block = 1;
        $user->save();
        session()->flash('flash_message' , 'حذف البشري تمت العملية ياض');
        return back();
    }
    public function block(){
        $users = User::where('Block' , 1)->get();
        return view('admin.block' , compact('users'));
    }
    public function unblock(User $user){
        $user->block = 0;
        $user->save();
        session()->flash('flash_message' , 'تمت عملية الغاء الحظر');
        return back();
    }
    public function Allchannels(){
        $users = User::all()->sortBy('created_at');
        return view('admin.Allchannels' , compact('users'));
    }
    public function TopVideos(){
        $Views = Views::orderBy('views_number' , 'desc')->take(10)->get(['user_id' , 'video_id' , 'views_number']);
        $vN = [];
        $vV = [];
        foreach($Views as $view){
            array_push($vN ,$view->video->title);
            array_push($vV ,$view->views_number);
        }
        return view('admin.TopVideos' , compact('Views' , 'vN' , 'vV'));
    }
}
