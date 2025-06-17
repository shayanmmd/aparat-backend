<?php

namespace App\Interfaces\Models\Playlist;

use App\Helpers\CustomResponse;
use App\Http\Requests\Playlist\CreatePlaylistRequest;

interface PlaylistRepositoryInterface
{
    public function create(CreatePlaylistRequest $request): CustomResponse;

    public function all(): CustomResponse;
}
