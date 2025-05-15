<?php

namespace App\Services\Email;

use App\Helpers\CustomResponse;
use App\Interfaces\Services\Email\EmailServiceInterface;

class EmailService implements EmailServiceInterface
{
    public function send($message): CustomResponse
    {
        $res = new CustomResponse;
        //TODO:implementing email service here
        return $res->succeed('email has been sent');
    }
}
