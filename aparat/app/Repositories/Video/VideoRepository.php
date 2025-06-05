<?php

namespace App\Repositories\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Interfaces\Models\Video\VideoRepositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use App\Models\Video;
use App\Services\FileUploader\FileUploader;
use Auth;
use File;
use Storage;

class VideoRepository implements VideoRepositoryInterface
{

    public function __construct(
        private FileUploaderInterface $fileUploaderInterface
    ) {}

    public function create(CreateVideoRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {

            // Video::create([
            //     'category-id' => $request->category_id,
            //     'user-id' => Auth::user()->id,
            //     'slug' => $request->slug,
            //     'title' => $request->title,
            //     'info' => $request->info,
            //     'duration' => $request->duration,
            //     'banner' => $request->banner,
            //     'publish-at' => $request->publish_at ?? now(),
            // ]);

            //TODO: video from temp file must be moved to another diirectory

          
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'ویدیو با موفقیت بارگزاری شد']);
    }

    public function upload(UploadVideoRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {

            //TODO: this temp video must not be publicly accessable

            $result = $this->fileUploaderInterface->store($request->file('video'), $request->name, '/temps', isMD5: true);

            if (!$result->isSuccessful())
                return $res->failed($result);

            return $res->succeed($result->getPayload());
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }
    }
}
