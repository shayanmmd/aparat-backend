<?php

namespace App\Interfaces\Models\Channel;

use App\Helpers\CustomResponse;
use App\Http\Requests\Channel\ChannelUpdateRequest;

interface ChannelRepositoryInterface
{
    public function update(ChannelUpdateRequest $request): CustomResponse;
}
