<?php

namespace App\Repositories\Auth;

use App\Helpers\CustomResponse;
use App\Http\Requests\AuthRequest;
use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Models\User;
use Hash as GlobalHash;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{


    public function __construct(
        private CustomResponse $res
    ) {}

    public function login(AuthRequest $request): CustomResponse
    {
        $email = $request->all()['email'];
        $password = $request->all()['password'];
        $user = User::where('email', '=', $email)->first();
        if (!$user || !Hash::check($password, $user->password))
            return $this->res->failed();
        $token = $user->createToken('hi');
        return $this->res->succeed($token->plainTextToken);
    }

    public function register() {}
}
