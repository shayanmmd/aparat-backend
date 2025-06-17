<?php

namespace App\Repositories\Playlist;

use App\Helpers\CustomResponse;
use App\Http\Requests\Playlist\CreatePlaylistRequest;
use App\Interfaces\Models\Playlist\PlaylistRepositoryInterface;
use App\Models\Playlist;
use Auth;

class PlaylistRepository implements PlaylistRepositoryInterface
{

    public function create(CreatePlaylistRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $playlist = Playlist::create([
                'user-id' => Auth::user()->id,
                'title' => $request->title
            ]);
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'ویدیو با موفقیت بارگزاری شد', 'id' => $playlist->id]);
    }

    public function all(): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $data = Playlist::where(['user-id' => Auth::user()->id])->get();
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'عملیات موفق', 'data' => $data]);
    }
}
