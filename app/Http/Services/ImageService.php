<?php

namespace App\Http\Services;

class ImageService
{
    private $imagePath = '/assets/avatars/';

    public function saveProfilePicture(object $picture)
    {
        if (!$picture->isValid()) {
            return null;
        }

        $pictureName = time() . uniqid() . '.' . $picture->getClientOriginalExtension();

        $picture->move(public_path('assets/avatars'), $pictureName);

        return  $this->imagePath . $pictureName;
    }

    public function deleteProfilePicture(string $pictureUrl)
    {
        $picturePath = str_replace(env('BASE_APP_URL'), '', $pictureUrl);
        
        $fullPath = public_path($picturePath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return true;
        }

        return false;
    }
}
