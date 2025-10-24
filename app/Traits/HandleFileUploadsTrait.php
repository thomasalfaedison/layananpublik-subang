<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait HandleFileUploadsTrait
{
    protected static function handleFileUploads(array &$data, array $fields, string $folder, $existingModel = null): void
    {

        foreach ($fields as $field) {
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                if ($existingModel && $existingModel->$field) {
                    static::deleteFileIfExists("$folder/{$existingModel->$field}");
                }

                $filename = static::generateUniqueFileName($data[$field]);
                $data[$field]->storeAs($folder, $filename, 'public');
                $data[$field] = $filename;
            } elseif ($existingModel) {
                $data[$field] = $existingModel->$field;
            }
        }
    }

    protected static function deleteFileIfExists(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected static function generateUniqueFileName(UploadedFile $file): string
    {
        return time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    }
}