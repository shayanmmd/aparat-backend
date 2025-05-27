<?php

namespace App\Interfaces\Models\User;

use App\Helpers\CustomResponse;
use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\VerifyChangeEmailRequest;

interface UserRespositoryInterface
{
    public function changeEmail(ChangeEmailRequest $request): CustomResponse;

    public function verifyChangeEmail(VerifyChangeEmailRequest $request): CustomResponse;
    public function changePassword(ChangePasswordRequest $request): CustomResponse;
}
