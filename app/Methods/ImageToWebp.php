<?php

namespace App\Methods;

use App\Traits\InteractWithFileStorage;
use Illuminate\Support\Facades\File;
use WebPConvert\WebPConvert;

class ImageToWebp
{
    use InteractWithFileStorage;

    public function convert($file)
    {
        $tempFileName = $this->generateUniqueFileName($file);
        $tempFilePath = storage_path("app/temp/");
        makeDirectory($tempFilePath);

        $file->move($tempFilePath, $tempFileName);
        $fileSource = $tempFilePath . $tempFileName;

        $filename = $this->generateUniqueFileName($file, false);
        $fileDestination = storage_path("app/temp/{$filename}.webp");
        WebPConvert::convert($fileSource, $fileDestination);

        File::delete($fileSource);

        return $this->pathToUploadedFile($fileDestination);
    }
}
