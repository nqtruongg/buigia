<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class Common
{

    public static function handleRemoveFile($filePath)
    {
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return true;
        }

        return false;
    }
}
