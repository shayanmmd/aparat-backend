<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Http\Requests\Video\VideoChangeStateRequest;
use App\Interfaces\Models\Video\VideoRepositoryInterface;

class VideoController extends Controller
{

    public function __construct(
        private VideoRepositoryInterface $videoRepositoryInterface
    ) {}

    public function create(CreateVideoRequest $request)
    {
        $res = $this->videoRepositoryInterface->create($request);
        return $res->json();
    }

    public function upload(UploadVideoRequest $request)
    {
        $res = $this->videoRepositoryInterface->upload($request);
        return $res->json();
    }

    public function changeState(VideoChangeStateRequest $request)
    {
        $res = $this->videoRepositoryInterface->changeState($request);
        return $res->json();
    }
}
