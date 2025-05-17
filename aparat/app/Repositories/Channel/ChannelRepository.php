<?php

namespace App\Repositories\Channel;

use App\Helpers\CustomResponse;
use App\Http\Requests\Channel\ChannelUpdateRequest;
use App\Interfaces\Models\Channel\ChannelRepositoryInterface;
use Exception;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function update(ChannelUpdateRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
        } catch (Exception $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => '']);

    }
}
