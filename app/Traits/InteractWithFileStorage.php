<?php

namespace App\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use League\MimeTypeDetection\GeneratedExtensionToMimeTypeMap;

trait InteractWithFileStorage
{
    public function generateUniqueFileName($file, $withExtension = true)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $filename = Str::random(15) . '_' . time();
        if ($withExtension) {
            $filename = $filename . '.' . strtolower($fileExtension);
        }
        return $filename;
    }

    public function pathToUploadedFile($path, $test = true)
    {
        $filesystem = new Filesystem;

        $name = $filesystem->name($path);
        $extension = $filesystem->extension($path);
        $originalName = $name . '.' . $extension;
        $mimeType = $filesystem->mimeType($path);
        $error = null;

        return new UploadedFile($path, $originalName, $mimeType, $error, $test);
    }

    public function fileExtension(string $mimeType): ?string
    {
        $arr = array_flip(GeneratedExtensionToMimeTypeMap::MIME_TYPES_FOR_EXTENSIONS);
        return $arr[$mimeType] ?? null;
    }

    public function fileMimeType(string $extension): ?string
    {
        return GeneratedExtensionToMimeTypeMap::MIME_TYPES_FOR_EXTENSIONS[$extension] ?? null;
    }

    public function isPublicFile($mimeType)
    {
        $mimeTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'video/mp4',
            'video/webm',
            'audio/mpeg',
            'audio/wav',
        ];
        return in_array($mimeType, $mimeTypes);
    }

    public function success(array $data)
    {
        $response = [
            'type' => 'success',
        ] + $data;
        return $this->response($response);
    }

    public function error(string $message)
    {
        $response = [
            'type' => 'error',
            'message' => $message,
        ];
        return $this->response($response);
    }

    protected function response($data)
    {
        return json_decode(json_encode($data));
    }
}