<?php

namespace App\Repositories\Channel;

use App\Helpers\CustomResponse;
use App\Http\Requests\Channel\ChannelUpdateRequest;
use App\Interfaces\Models\Channel\ChannelRepositoryInterface;
use App\Models\Channel;
use Auth;
use Exception;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function update(ChannelUpdateRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $currentUserId = Auth::id();

            $channel = Channel::where('user-id', '=', $currentUserId)->firstOrFail();

            if (!$channel)
                return $res->failed(['message' => 'کانال وجود ندارد']);

            $isUpdated = $channel->update([
                'info' => $request->update,
                'socials' => $request->socials
            ]);

            if (! $isUpdated)
                return $res->failed(['message' => 'کانال به درستی ویرایش نشد']);
        } catch (Exception $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'کانال با موفقیت ویرایش شد']);
    }

    public function createOrUpdateBanner($bannerUrl): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $channel = Channel::where('user-id', '=', Auth::user()->id)->firstOrFail();
            if (!$channel)
                return $res->failed();

            $isUpdated = $channel->update([
                'picture' => $bannerUrl
            ]);

            if (!$isUpdated)
                return $res->failed();

        } catch (\Throwable $th) {
            dd($th);
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'تصویر کانال با موفقیت تغییر کرد']);
    }
}
