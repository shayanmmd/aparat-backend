<?php

namespace App\Interfaces\Services\Email;

use App\Helpers\CustomResponse;

interface EmailServiceInterface
{
    public function send($message): CustomResponse;
}
