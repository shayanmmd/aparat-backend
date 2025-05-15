<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class CustomResponse
{

    private $success = false;
    private $message;
    private $payload;
    private $statuscode;

    public function failed($message = "", $statuscode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $this->message = $message;
        $this->success = false;
        $this->statuscode = $statuscode;
        return $this;
    }

    public function succeed($payload, $statuscode = Response::HTTP_OK)
    {
        $this->success = true;
        $this->payload = $payload;
        $this->statuscode = $statuscode;
        return $this;
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getStatusCode()
    {
        return $this->statuscode;
    }
}
