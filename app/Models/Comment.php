<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Video;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
