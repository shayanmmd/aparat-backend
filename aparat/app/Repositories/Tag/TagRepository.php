<?php

namespace App\Repositories\Tag;

use App\Helpers\CustomResponse;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Interfaces\Models\Tag\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{

    public function create(CreateTagRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $tag = Tag::create(['title' => $request->title]);
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'عملیات موفق', 'id' => $tag->id]);
    }

    public function all(): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $data = Tag::all();
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'عملیات موفق', 'data' => $data]);
    }
}
