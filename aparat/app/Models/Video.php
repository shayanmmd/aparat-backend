<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Video extends Model
{
    protected $table = 'videos';
    protected $guarded = ['id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'video-tags','video-id','tag-id');
    }
}
