<?php

namespace App\Policies;

use App\Models\Republish;
use App\Models\User;

class VideoPolicy
{
    public function changeState(User $user): bool
    {
        if ($user->type == 'admin')
            return true;
        return false;
    }

    public function republish(User $user, $video_id)
    {
        $alreadyExists = Republish::where([
            'user-id' => $user->id,
            'video-id' =>  $video_id
        ])->exists();
            
        if ($alreadyExists)
            return false;

        return true;
    }
}
