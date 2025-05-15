<?php

namespace App\Repositories\Auth;

use App\Helpers\CustomResponse;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{

    public function __construct(
        private CustomResponse $res
    ) {}

    public function login(AuthLoginRequest $request): CustomResponse
    {
        $email = $request->all()['email'];
        $password = $request->all()['password'];
        $user = User::where('email', '=', $email)->first();
        if (!$user || !Hash::check($password, $user->password))
            return $this->res->failed();
        $token = $user->createToken('auth.login');
        return $this->res->succeed($token->plainTextToken);
    }

    public function register($email, $verfy_code, $password): CustomResponse
    {
        try {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'verify_code' => $verfy_code
            ]);
        } catch (Exception $e) {
            return $this->res->failed();
        }
        return $this->res->succeed(new UserResource($user));
    }
}
