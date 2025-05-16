<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function index(){
        $videosCount = Video::count();
        $channelsCount = User::count();

        return view('admin.index' , compact('videosCount' , 'channelsCount'));
    }
}
