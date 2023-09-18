<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Uploader {
    /**
     * The function uploads and replaces an image file while deleting the previous image if it exists.
     * 
     * @param file The file parameter is a file object that represents the uploaded file.
     * @param config It is a variable that contains an object or an array of configuration settings. The
     * function uses this variable to access the current value of the attribute that represents the file
     * name of the image.
     * @param attribute The name of the attribute in the  object that contains the file path of the
     * previous image.
     * @param path The path where the file will be stored.
     * 
     * @return the name of the image file, which is either the basename of the `->`
     * variable (if no new file is uploaded), or a newly generated unique filename with the extension of
     * the uploaded file.
     */
    public static function file($file, $model = null, $attribute = null, $path = '/', $fileName = false) {
        $image = isset($model) ? basename($model->$attribute) : null;
        if ($file) {
            // Generate a unique file name for the image
            $imageName = ($fileName ?: uniqid()) . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/' . $path, $imageName);

            // Delete the previous image if it exists
            if (isset($model) && $model->$attribute && Storage::disk('public')->exists($path . '/' . basename($model->$attribute))) {
                Storage::disk('public')->delete($path . '/' . basename($model->$attribute));
            }

            $image = $imageName;
        }

        return $image;
    }
}
