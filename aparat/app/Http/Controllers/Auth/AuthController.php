<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Requests\Auth\AuthVerifyRegisterRequest;
use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Models\Channel;
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
                'message' => 'ایمیل یا پسوورد اشتباه است'
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
        $code = generateCodeRandom();
        //TODO:ارسال کد تاییدیه به کاربر در ایمیل 
        $response = $this->authRepositoryInterface->register($request->email, $code, $request->password);
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

    public function verifyRegister(AuthVerifyRegisterRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'این ایمیل در سیستم وجود ندارد'
            ], Response::HTTP_BAD_REQUEST);
        }
        if (!is_null($user->verify_at)) {
            return response()->json([
                'message' => 'این ایمیل در سیستم تایید شده است'
            ], Response::HTTP_BAD_REQUEST);
        }
        if ($user->verify_code != $request->code) {
            return response()->json([
                'message' => 'کد تایید اشتباه است'
            ], Response::HTTP_BAD_REQUEST);
        }
        $isUpdated = $user->update([
            'verify_at' => now(),
            'verify_code' => null
        ]);
        if (!$isUpdated) {
            return response()->json([
                'message' => 'کاربر بروزرسانی نشد'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        Channel::create([
            'name' => $user->email,
            'user-id' => $user->id
        ]);
        return response()->json([
            'message' => 'کاربر در سیستم با موفقیت تایید شد'
        ], Response::HTTP_OK);
    }
}
