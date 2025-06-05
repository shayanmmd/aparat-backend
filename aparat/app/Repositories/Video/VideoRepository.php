<?php

namespace App\Repositories\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Interfaces\Models\Video\VideoRepositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use Auth;

class VideoRepository implements VideoRepositoryInterface
{

    public function __construct(
        private FileUploaderInterface $fileUploaderInterface
    ) {}

    public function create(CreateVideoRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'ویدیو با موفقیت بارگزاری شد']);
    }

    public function upload(UploadVideoRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $result = $this->fileUploaderInterface->store($request->file('video'), Auth::user()->id, '/temps', isMD5: true);

            if (!$result->isSuccessful())
                return $result;

            return $result->getPayload();
            
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }
    }
}
