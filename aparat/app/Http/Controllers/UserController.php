<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\VerifyChangeEmailRequest;
use App\Interfaces\User\UserRespositoryInterface;

class UserController extends Controller
{

    public function __construct(
        private UserRespositoryInterface $userRespositoryInterface
    ) {}


    public function changeEmail(ChangeEmailRequest $request)
    {
        $res =  $this->userRespositoryInterface->changeEmail($request);
        
    }

    public function verifyChangeEmail(VerifyChangeEmailRequest $request)
    {
        return $this->userRespositoryInterface->verifyChangeEmail($request);
    }
}
