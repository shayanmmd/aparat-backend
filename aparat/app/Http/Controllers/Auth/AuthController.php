<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Interfaces\Auth\AuthRepositoryInterface;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function __construct(
        private AuthRepositoryInterface $authRepositoryInterface
    ) {}

    public function login(AuthRequest $request)
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
}
