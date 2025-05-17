<?php

namespace App\Interfaces\Models\Auth;

use App\Helpers\CustomResponse;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthVerifyRegisterRequest;

interface AuthRepositoryInterface
{
    public function login(AuthLoginRequest $request): CustomResponse;
    public function register($email, $verfy_code, $password): CustomResponse;
    public function verifyRegister(AuthVerifyRegisterRequest $request): CustomResponse;
}
