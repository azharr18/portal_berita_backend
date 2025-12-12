<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = [];
    
    public function comments() {
        return $this->hasMany(Comment::class)->with('user'); // Include user info
    }
}
