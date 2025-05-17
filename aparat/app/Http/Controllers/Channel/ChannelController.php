<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channel\ChannelUpdateRequest;
use App\Interfaces\Models\Channel\ChannelRepositoryInterface;

class ChannelController extends Controller
{

    public function __construct(
        private ChannelRepositoryInterface $channelRepositoryInterface
    ) {}

    public function update(ChannelUpdateRequest $request)
    {
        $response = $this->channelRepositoryInterface->update($request);
        return $response->json();
    }
}
