<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Response;

class CustomResponse
{

    private $success = false;
    private $payload;
    private $statuscode;

    public function failed($payload = "", $statuscode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $this->payload = $payload;
        $this->success = false;
        $this->statuscode = $statuscode;
        return $this;
    }

    public function tryCatchError()
    {
        $this->success = false;
        $this->payload = [
            'message' => 'خطایی در سرور رخخ داده است. با پشتیبانی تماس بگیرید'
        ];
        $this->statuscode = Response::HTTP_INTERNAL_SERVER_ERROR;
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

    public function getPayload()
    {
        return $this->payload;
    }

    public function getStatusCode()
    {
        return $this->statuscode;
    }

    public function json()
    {
        return response()->json($this->getPayload(), $this->getStatusCode());
    }
}
