<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

trait Utility
{
    protected function uploadPhotos( array $uploadedFiles = null): array
    {
        if (is_null($uploadedFiles))
            return [];

        $path = public_path('images/');

        $photos = [];
        foreach ($uploadedFiles as $key => $file) {
            $ext = $file->getClientOriginalExtension();

            $imageName = Str::uuid() . "." . $ext;

            $file->move($path, $imageName);
            $photos[] = $imageName;
        }

        return $photos;
    }
}
