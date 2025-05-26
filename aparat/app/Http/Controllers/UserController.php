<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\VerifyChangeEmailRequest;

class UserController extends Controller
{

    public function __construct(
        private \App\Interfaces\Models\User\UserRespositoryInterface $userRespositoryInterface
    ) {}


    public function changeEmail(ChangeEmailRequest $request)
    {
        $response =  $this->userRespositoryInterface->changeEmail($request);

        return $response->json();
    }

    public function verifyChangeEmail(VerifyChangeEmailRequest $request)
    {
        $response = $this->userRespositoryInterface->verifyChangeEmail($request);

        return $response->json();
    }
}
