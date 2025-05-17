<?php

namespace App\Repositories\Auth;

use App\Helpers\CustomResponse;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthVerifyRegisterRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\Models\Auth\AuthRepositoryInterface;
use App\Models\Channel;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{

    public function login(AuthLoginRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $email = $request->all()['email'];
            $password = $request->all()['password'];
            $user = User::where('email', '=', $email)->first();
            if (!$user || !Hash::check($password, $user->password))
                return $res->failed([
                    'message' => 'ایمیل یا پسوورد اشتباه است'
                ], Response::HTTP_BAD_REQUEST);
            $token = $user->createToken('auth.login');
        } catch (Exception $th) {
            return $res->tryCatchError();
        }

        return $res->succeed([
            'token' => $token->plainTextToken
        ]);
    }

    public function register($email, $verfy_code, $password): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'verify_code' => $verfy_code
            ]);
        } catch (Exception $e) {
            return $res->tryCatchError();
        }
        return $res->succeed([
            'message' => 'کاربر موقتا ثبت شد. در انتظار کد تایید',
            'user' => new UserResource($user)
        ]);
    }

    public function verifyRegister(AuthVerifyRegisterRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $user = User::where('email', '=', $request->email)->first();
            if (!$user) {
                return $res->failed([
                    'message' => 'این ایمیل در سیستم وجود ندارد'
                ], Response::HTTP_BAD_REQUEST);
            }
            if (!is_null($user->verify_at)) {
                return $res->failed([
                    'message' => 'این ایمیل در سیستم تایید شده است'
                ], Response::HTTP_BAD_REQUEST);
            }
            if ($user->verify_code != $request->code) {
                return $res->failed([
                    'message' => 'کد تایید اشتباه است'
                ], Response::HTTP_BAD_REQUEST);
            }
            $isUpdated = $user->update([
                'verify_at' => now(),
                'verify_code' => null
            ]);
            if (!$isUpdated) {
                return $res->failed([
                    'message' => 'کاربر بروزرسانی نشد'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            Channel::create([
                'name' => $user->email,
                'user-id' => $user->id
            ]);
        } catch (Exception $e) {
            $res->tryCatchError();
        }

        return $res->succeed([
            'message' => 'کاربر در سیستم با موفقیت تایید شد'
        ], Response::HTTP_OK);
    }
}
