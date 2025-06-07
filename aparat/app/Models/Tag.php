<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['title'];

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video-tags','tag-id','video-id');
    }
}
