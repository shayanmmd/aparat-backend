<?php

namespace App\Interfaces\Models\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;

interface VideoRepositoryInterface
{
    public function create(CreateVideoRequest $request): CustomResponse;
    public function upload(UploadVideoRequest $request): CustomResponse;
}
