<?php

namespace App\Helpers;

class CustomResponse
{

    private $success = false;
    private $message;
    private $payload;

    public function failed($message = "")
    {
        $this->message = $message;
        $this->success = false;
        return $this;
    }

    public function succeed($payload)
    {
        $this->success = true;
        $this->payload = $payload;
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
}
