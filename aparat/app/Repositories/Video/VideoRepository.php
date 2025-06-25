<?php

namespace App\Repositories\Video;

use App\Helpers\CustomResponse;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UploadVideoRequest;
use App\Http\Requests\Video\VideoChangeStateRequest;
use App\Interfaces\Models\Video\VideoRepositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use App\Models\Video;
use Auth;
use DB;
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

            $from = 'temps/' . md5($request->slug) . '.mp4';
            $to = 'videos/' . md5($request->slug) . '.mp4';

            $isMoved = Storage::disk('public')->move($from, $to);

            if (!$isMoved)
                return $res->failed(['message' => 'خطا در اپلود ویدیو'], Response::HTTP_BAD_REQUEST);

            DB::beginTransaction();

            $video = Video::create([
                'category-id' => $request->category_id,
                'user-id' => Auth::user()->id,
                'slug' => $request->slug,
                'title' => $request->title,
                'info' => $request->info,
                'duration' => $request->duration,
                'publish-at' => $request->publish_at ?? now(),
                'enable-comments' => $request->enable_comments ?? true
            ]);

            $video->tags()->attach($request->tags);
            $video->playlist()->attach($request->playlist);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
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

    public function changeState(VideoChangeStateRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $video = Video::where(['slug' => $request->slug])->first();

            if (empty($video))
                return $res->failed(['message' => ' این فیلد اسلاگ در سیستم وجود ندارد']);

            $video->state = $request->state;

            $isSuccess = $video->save();

            if (! $isSuccess)
                return $res->failed(['message' => 'وضعیت تغییر پیدا نکرد. دوباره تلاش کنید']);

            return $res->succeed(['message' => 'وضعیت ویدیو با موفقیت تغییر یافت']);
            
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }
    }
}
