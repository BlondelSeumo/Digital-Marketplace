<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Traits\InteractWithFileStorage;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LocalController extends Controller
{
    use InteractWithFileStorage;

    public function upload($file, $path, $mimeType)
    {
        try {
            $filename = $this->generateUniqueFileName($file);
            $fileSource = $this->isPublicFile($mimeType) ? public_path($path) : storage_path("app/{$path}");
            $upload = $file->move($fileSource, $filename);
            if ($upload) {
                return $this->success([
                    "filename" => $filename,
                    "path" => $path . $filename,
                ]);
            } else {
                return $this->error(translate('The upload failed due to an error in the storage provider'));
            }
        } catch (Exception $e) {
            return $this->error(translate('The upload failed due to an error in the storage provider'));
        }
    }

    public function download($path, $filename)
    {
        try {
            $disk = Storage::disk('local');
            if (!$disk->exists($path)) {
                return $this->error(translate('The requested file are not exists'));
            }
            $headers = [
                'Content-Type' => $disk->mimeType($path),
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => $disk->size($path),
            ];
            return new StreamedResponse(function () use ($path, $disk) {
                $stream = $disk->readStream($path);
                while (!feof($stream) && connection_status() === 0) {
                    echo fread($stream, 1024 * 8);
                    flush();
                }
                fclose($stream);
            }, 200, $headers);
        } catch (Exception $e) {
            return $this->error(translate('The download failed due to an error on the storage provider'));
        }
    }

    public function delete($path)
    {
        $directDisk = Storage::disk('direct');
        $localDisk = Storage::disk('local');
        if ($directDisk->has($path)) {
            $directDisk->delete($path);
        } elseif ($localDisk->has($path)) {
            $localDisk->delete($path);
        }
        return true;
    }

}