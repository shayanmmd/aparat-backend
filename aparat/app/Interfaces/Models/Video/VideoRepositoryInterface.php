<?php

namespace App\Interfaces\Models\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\RepublishVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Http\Requests\Video\VideoChangeStateRequest;
use App\Http\Requests\Video\VideoListRequest;

interface VideoRepositoryInterface
{
    public function list(VideoListRequest $request): CustomResponse;
    public function create(CreateVideoRequest $request): CustomResponse;
    public function upload(UploadVideoRequest $request): CustomResponse;
    public function changeState(VideoChangeStateRequest $request): CustomResponse;
    public function republish(RepublishVideoRequest $request): CustomResponse;
}
