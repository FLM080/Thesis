<?php

namespace App\Services;

class ImageService
{
    public function getImagePath($directory, $id, $defaultPath)
    {
        $extensions = config('images.profile.extension');
        $filePath = "images/{$directory}/{$id}";
    
        $imagePath = $defaultPath;
    
        foreach ($extensions as $extension) {
            $tempPath = $filePath . '.' . $extension;
            if (file_exists(public_path($tempPath))) {
                $imagePath = $tempPath;
            }
        }
    
        return $imagePath;
    }
}