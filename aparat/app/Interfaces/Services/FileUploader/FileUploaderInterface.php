<?php

namespace App\Interfaces\Services\FileUploader;

use App\Helpers\CustomResponse;

interface FileUploaderInterface
{
    public function store($file, $name, $path = '/', $visibility = 'public', $isMD5 = false): CustomResponse;
}
