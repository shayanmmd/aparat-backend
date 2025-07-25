<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';
    protected $fillable = ['user-id', 'title'];

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'playlist-videos', 'playlist-id', 'video-id');
    }
}
