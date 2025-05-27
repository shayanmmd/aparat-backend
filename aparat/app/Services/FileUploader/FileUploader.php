<?php

namespace App\Services\FileUploader;

use App\Helpers\CustomResponse;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use Storage;

class FileUploader implements FileUploaderInterface
{

    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';

    public function store($file, $name, $path = '/', $visibility = FileUploader::VISIBILITY_PUBLIC, $isMD5 = false): CustomResponse
    {

        $res = new CustomResponse;

        try {
            if ($isMD5)
                $name = md5($name);

            $fileName = $name . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($path, $fileName, $visibility);
        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        $url = url('storage/' . $path);

        return $res->succeed($url);
    }
}
