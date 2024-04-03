<?php

namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
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
                break;
            }
        }
    
        return $imagePath;
    }

    public static function uploadAndResize($image, $id, $destinationPath)
    {
        $extension = strtolower($image->getClientOriginalExtension());
        $name = $id . '.' . $extension;
        $destinationPath = public_path($destinationPath);

        $existingFiles = glob($destinationPath . '/' . $id . '.*');
        foreach ($existingFiles as $existingFile) {
            if ($existingFile !== $destinationPath . '/' . $name) {
                unlink($existingFile);
            }
        }

        $resizedImage = Image::make($image)->resize(320, 320, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $resizedImage->save($destinationPath . '/' . $name);

        return $destinationPath . '/' . $name;
    }

    public static function deleteImage($id, $destinationPath)
    {
        $extensions = config('images.profile.extension');
        $imageDeleted = false;

        foreach ($extensions as $extension) {
            $fileToDelete = public_path($destinationPath) . '/' . $id . '.' . $extension;

            if (is_file($fileToDelete)) {
                if (unlink($fileToDelete)) {
                    $imageDeleted = true;
                    break;
                }
            }
        }

        return $imageDeleted;
    }
}