<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ConvertedVideos;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Views;
class Video extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function convert(){
        return $this->hasMany(ConvertedVideos::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function views(){
        return $this->hasMany(Views::class);
    }
    public function users(){
        return $this->belongsToMany(Video::class ,'video_user', 'video_id' , 'user_id')->withTimestamps()->withPivot('id');
    }
}
