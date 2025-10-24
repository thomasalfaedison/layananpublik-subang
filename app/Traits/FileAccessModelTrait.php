<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileAccessModelTrait
{
    public function hasFile(string $field, string $folder): bool
    {
        return !empty($this->$field) && Storage::disk('public')->exists("$folder/{$this->$field}");
    }

    public function getFileUrl(string $field, string $folder): ?string
    {
        if ($this->hasFile($field, $folder)) {
            return asset("storage/$folder/{$this->$field}");
        }

        return null;
    }
}