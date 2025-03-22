<?php

namespace App\Interfaces\Auth;

use App\Helpers\CustomResponse;
use App\Http\Requests\AuthRequest;

interface AuthRepositoryInterface
{
    public function login(AuthRequest $request):CustomResponse;
    public function register();
}
