<?php

namespace App\Console\Commands;

use App\Models\UploadedFile;
use Illuminate\Console\Command;

class DeleteExpiredUploadedFiles extends Command
{
    protected $signature = 'app:delete-expired-uploaded-files';

    protected $description = 'This command will delete expired uploaded files';

    public function handle()
    {
        $uploadedFiles = UploadedFile::expired()->get();

        foreach ($uploadedFiles as $uploadedFile) {
            $uploadedFile->deleteFile();
            $uploadedFile->delete();
        }

        $this->info('The expired uploaded files has been deleted');
    }
}
