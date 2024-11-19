<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Methods\ImageToWebp;
use App\Methods\Watermark;
use App\Models\Category;
use App\Models\StorageProvider;
use App\Models\UploadedFile;
use App\Traits\InteractWithFileStorage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Vironeer\ChunkUpload\Handler\HandlerFactory;
use Vironeer\ChunkUpload\Receiver\FileReceiver;

class FileController extends Controller
{
    use InteractWithFileStorage;

    public function upload(Request $request, $category_id)
    {
        if (demoMode()) {
            return $this->error('Some features are disabled in the demo version');
        }

        $originalFileName = $request->file('file')->getClientOriginalName();

        if (strip_tags($originalFileName) !== $originalFileName) {
            return $this->error(translate('The file name contain blocked patterns'));
        }

        if (preg_match('/\{\{[^}]*\}\}|{!![^}]*!!}|<\?php|\{\}|\{[^}]*\}/', $originalFileName)) {
            return $this->error(translate('The file name contain blocked patterns'));
        }

        $category = Category::where('id', $category_id)->firstOrFail();

        $uploadedFileExists = UploadedFile::where('name', $originalFileName)
            ->where('category_id', $category->id)->first();
        if ($uploadedFileExists) {
            return $this->error(translate('You cannot attach the same file twice'));
        }

        try {
            $storageProvider = storageProvider();
            if (!$storageProvider) {
                return $this->error(translate('Unavailable storage provider'));
            }

            $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                return $this->error(translate('Failed to upload (:filename)', ['filename' => $originalFileName]));
            }

            $save = $receiver->receive();
            if (!$save->isFinished()) {
                return $this->error(translate('Failed to upload (:filename)', ['filename' => $originalFileName]));
            }

            $file = $save->getFile();
            $fileExtension = $file->getClientOriginalExtension();
            $fileMimeType = ($this->fileMimeType($fileExtension)) ? $this->fileMimeType($fileExtension) : $file->getMimeType();
            $fileSize = $file->getSize();

            if ($fileSize == 0) {
                return $this->error(translate('Empty files cannot be uploaded'));
            }

            $itemSettings = settings('item');

            if (in_array($fileMimeType, ['image/png', 'image/jpg', 'image/jpeg'])) {
                if (isAddonActive('watermark') && @settings('watermark')->status) {
                    $watermark = new Watermark();
                    $file = $watermark->add($file);
                }

                if (@$itemSettings->convert_images_webp) {
                    $image = new ImageToWebp();
                    $file = $image->convert($file);
                }
            }

            $processor = new $storageProvider->processor;
            $response = $processor->upload($file, 'files/items/', $fileMimeType);

            if ($response->type == "error") {
                return $this->error($response->message);
            }

            if ($response->type != "success") {
                return $this->error(translate('Failed to upload (:filename)', ['filename' => $originalFileName]));
            }

            $uploadedFile = UploadedFile::create([
                'name' => $originalFileName,
                'mime_type' => $fileMimeType,
                'extension' => $fileExtension,
                'size' => $fileSize,
                'path' => $response->path,
                'expiry_at' => Carbon::now()->addHours(@$itemSettings->file_duration),
                'category_id' => $category->id,
            ]);

            if (!$uploadedFile) {
                return $this->error(translate('Failed to upload (:filename)', ['filename' => $originalFileName]));
            }

            return $this->success([
                'id' => $uploadedFile->id,
                'name' => $uploadedFile->name,
                'size' => $uploadedFile->getSize(),
                'mime_type' => $uploadedFile->mime_type,
                'extension' => $uploadedFile->extension,
                'link' => $uploadedFile->getFileLink(),
                'time' => $uploadedFile->created_at->diffforhumans(),
                'delete_link' => route('admin.items.files.delete', [$category->id, $uploadedFile->id]),
            ]);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function loadFiles($category_id)
    {
        $uploadedFiles = UploadedFile::where('category_id', $category_id)
            ->notExpired()->select(['id', 'name'])
            ->get();

        $result = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $result[$uploadedFile->id] = $uploadedFile->getShortName();
        }

        return response()->json($result);
    }

    public function deleteFile($category_id, $id)
    {
        $uploadedFile = UploadedFile::where('id', $id)
            ->where('category_id', $category_id)
            ->notExpired()
            ->first();

        if ($uploadedFile) {
            try {
                $uploadedFile->deleteFile();
                $uploadedFile->delete();
            } catch (Exception $e) {
                response()->json(['error' => $e->getMessage()]);
                return back();
            }
        }

        return response()->json([
            'success' => translate('File has been deleted successfully'),
        ]);
    }
}
