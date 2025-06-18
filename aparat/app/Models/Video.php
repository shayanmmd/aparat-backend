<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Video extends Model
{

    const PENDING = 'pending';
    const CONFIRMED = 'confirmed';
    const BLOCKED = 'blocked';
    const STATES = [self::PENDING, self::CONFIRMED, self::BLOCKED];

    protected $table = 'videos';
    protected $guarded = ['id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'video-tags', 'video-id', 'tag-id');
    }

    public function playlist()
    {
        return $this->belongsToMany(Playlist::class, 'playlist-videos', 'video-id', 'playlist-id');
    }
}
