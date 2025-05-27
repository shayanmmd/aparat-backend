<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channel\ChannelUpdateRequest;
use App\Http\Requests\Channel\UploadBannerRequest;
use App\Interfaces\Models\Channel\ChannelRepositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use App\Models\Channel;
use Auth;
use Storage;

class ChannelController extends Controller
{

    public function __construct(
        private ChannelRepositoryInterface $channelRepositoryInterface,
        private FileUploaderInterface $fileUploaderInterface
    ) {}

    public function update(ChannelUpdateRequest $request)
    {
        $response = $this->channelRepositoryInterface->update($request);
        return $response->json();
    }

    public function uploadBanner(UploadBannerRequest $request)
    {
        $url = $this->fileUploaderInterface->store($request->file('banner'), Auth::id(), 'channel-banners', isMD5: true);
        if (!$url->isSuccessful())
            return $url->json();
        $res = $this->channelRepositoryInterface->createOrUpdateBanner($url->getPayload());

        return $res->json();
    }
}
