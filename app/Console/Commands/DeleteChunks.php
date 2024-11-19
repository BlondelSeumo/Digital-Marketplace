<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteChunks extends Command
{
    protected $signature = 'app:delete-chunks';

    protected $description = 'Delete the chunk parts from the chunks folder in storage';

    public function handle()
    {
        $chunkDirectory = storage_path('app/chunks');

        if (File::exists($chunkDirectory)) {
            $threeHoursAgo = Carbon::now()->subHours(5);
            $files = File::files($chunkDirectory);
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $fileModifiedTime = Carbon::createFromTimestamp(File::lastModified($file));
                    if ($fileModifiedTime->lte($threeHoursAgo)) {
                        File::delete($file);
                    }
                }
            }
        }

        $this->info('The chunks has been deleted');
    }
}
