<?php

namespace App\Repositories\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Interfaces\Models\Video\VideoRepositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use App\Models\Video;
use Auth;
use Illuminate\Http\Response;
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

            //TODO: create playlist with creating video

            $from = 'temps/' . md5($request->slug) . '.mp4';
            $to = 'videos/' . md5($request->slug) . '.mp4';

            $isMoved = Storage::disk('public')->move($from, $to);

            if (!$isMoved)
                return $res->failed(['message' => 'خطا در اپلود ویدیو'], Response::HTTP_BAD_REQUEST);

            $video = Video::create([
                'category-id' => $request->category_id,
                'user-id' => Auth::user()->id,
                'slug' => $request->slug,
                'title' => $request->title,
                'info' => $request->info,
                'duration' => $request->duration,
                'publish-at' => $request->publish_at ?? now(),
            ]);

            $video->tags()->attach($request->tags);

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

            $result = $this->fileUploaderInterface->store($request->file('video'), $request->slug, '/temps', isMD5: true);

            if (!$result->isSuccessful())
                return $res->failed($result);

            return $res->succeed($result->getPayload());
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }
    }
}
