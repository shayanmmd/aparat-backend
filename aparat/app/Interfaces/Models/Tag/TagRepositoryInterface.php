<?php

namespace App\Interfaces\Models\Tag;

use App\Helpers\CustomResponse;
use App\Http\Requests\Tag\CreateTagRequest;

interface TagRepositoryInterface
{
    public function create(CreateTagRequest $request): CustomResponse;
    public function all(): CustomResponse;
}
