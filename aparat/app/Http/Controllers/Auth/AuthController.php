<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function __construct(
        private AuthRepositoryInterface $authRepositoryInterface
    ) {}

    public function login(AuthLoginRequest $request)
    {
        $response =  $this->authRepositoryInterface->login($request);

        if (!$response->isSuccessful()) {
            return response()->json([
                'message' => 'email or password is wrong'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'token' => $response->getPayload()
        ]);
    }

    public function register(AuthRegisterRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => 'این ایمیل در سیستم وجود دارد'
            ], Response::HTTP_BAD_REQUEST);
        }
        $code = random_int(10, 99) . random_int(10, 99) . random_int(10, 99);
        //TODO:ارسال کد تاییدیه به کاربر در ایمیل 
        $response = $this->authRepositoryInterface->register($request->email, $code);
        if (!$response->isSuccessful()) {
            return response()->json([
                $response->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'message' => 'کاربر موقتا ثبت شد. در انتظار کد تایید',
            'user' => $response->getPayload()
        ], 200);
    }

    public function verifyRegister() {}
}
