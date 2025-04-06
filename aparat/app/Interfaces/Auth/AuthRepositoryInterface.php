<?php

namespace App\Interfaces\Auth;

use App\Helpers\CustomResponse;
use App\Http\Requests\Auth\AuthLoginRequest;

interface AuthRepositoryInterface
{
    public function login(AuthLoginRequest $request):CustomResponse;
    public function register($email,$verfy_code,$password) : CustomResponse;
}
