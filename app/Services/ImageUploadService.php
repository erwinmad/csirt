<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload an image file directly to public storage
     *
     * @param mixed $file The uploaded file
     * @param string $subDirectory Subdirectory within 'public' disk
     * @return string The path to the stored file
     */
    public function uploadToPublic($file, string $subDirectory = 'halaman'): string
    {
        if (!is_object($file)) {
            throw new \InvalidArgumentException('Invalid file provided');
        }

        // Generate unique filename
        $filename = $this->generateUniqueFilename($file);

        // Store directly to public disk
        $path = $file->storeAs($subDirectory, $filename, 'public');

        return $path;
    }

    /**
     * Generate a unique filename
     */
    protected function generateUniqueFilename($file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        return Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
    }

    /**
     * Delete an image from public storage
     *
     * @param string $filePath Relative path to file in public storage
     * @return bool True if deletion was successful
     */
    public function deleteFromPublic(string $filePath): bool
    {
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }
}