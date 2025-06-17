<?php

namespace App\Http\Controllers\Playlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Playlist\CreatePlaylistRequest;
use App\Interfaces\Models\Playlist\PlaylistRepositoryInterface;

class PlaylistController extends Controller
{

    public function __construct(
        private PlaylistRepositoryInterface $playlistRepositoryInterface
    ) {}

    public function create(CreatePlaylistRequest $request)
    {
        $response = $this->playlistRepositoryInterface->create($request);
        return $response->json();
    }

    public function all()
    {
        $response = $this->playlistRepositoryInterface->all();
        return $response->json();
    }
}
