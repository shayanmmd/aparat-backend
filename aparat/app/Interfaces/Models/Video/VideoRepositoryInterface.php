<?php

namespace App\Interfaces\Models\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Http\Requests\Video\VideoChangeStateRequest;

interface VideoRepositoryInterface
{
    public function create(CreateVideoRequest $request): CustomResponse;
    public function upload(UploadVideoRequest $request): CustomResponse;
    public function changeState(VideoChangeStateRequest $request): CustomResponse;
}
