<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    protected $guarded = [];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
