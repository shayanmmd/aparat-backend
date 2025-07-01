<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\Response;

class VideoPolicy
{

    public function changeState(User $user): bool
    {
        if($user->type == 'admin')
            return true;
        return false;
    }
}
