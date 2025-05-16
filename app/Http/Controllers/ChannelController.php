<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index(){
        $channels = User::all()->sortByDesc('created_at');
        $title = 'احدث القنوات' ;
        return view('channels' , compact('channels' , 'title'));
    }
    public function search(Request $request){
        $channels = User::where('name' , 'like' , "%{$request->title}%")->paginate(12);
        $title = 'نتائج البحث عن :' . $request->title;
        return view('channels' , compact('channels' , 'title'));
   
    }
}
