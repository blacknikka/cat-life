<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class S3Service
{
    public function PutAFile($path, $content): string|null
    {
        try {
            return Storage::disk('s3')->put($path, $content);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            Log::error("Failed to put a file {$path}: {$message}");
            return null;
        }
    }

    public function GetAFile($path)
    {
        try {
            return Storage::disk('s3')->get($path);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            Log::error("Failed to get a file ${$path}: ${$message}");
            return null;
        }
    }
}
