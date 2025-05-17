<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Requests\Auth\AuthVerifyRegisterRequest;
use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Interfaces\Services\Email\EmailServiceInterface;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function __construct(
        private AuthRepositoryInterface $authRepositoryInterface,
        private EmailServiceInterface $emailServiceInterface
    ) {}

    public function login(AuthLoginRequest $request)
    {
        $response =  $this->authRepositoryInterface->login($request);
        return $response->json();
    }

    public function register(AuthRegisterRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => 'این ایمیل در سیستم وجود دارد'
            ], Response::HTTP_BAD_REQUEST);
        }
        $code = generateCodeRandom();

        $this->emailServiceInterface->send($code);

        $response = $this->authRepositoryInterface->register($request->email, $code, $request->password);

        return $response->json();
    }

    public function verifyRegister(AuthVerifyRegisterRequest $request)
    {
        $response =  $this->authRepositoryInterface->verifyRegister($request);
        return $response->json();
    }
}
