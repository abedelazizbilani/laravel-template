<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class Thumb
{
    /**
     * Make thumb if Post model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function makeThumb(Model $model)
    {
        $path = $model->image;

        $dir = dirname ($path);
        if ($dir != '\files') {
            $dir = substr_replace ($dir, '', 0, 7);
            if (!in_array($dir , Storage::disk('thumbs')->directories())) {
                Storage::disk('thumbs')->makeDirectory($dir);
            }
        }

        $image = Image::make($path)->widen(100);
        Storage::disk('thumbs')->put(substr_replace (self::makeThumbPath($path), '', 0, 7), $image->encode());
    }

    /**
     * Make thumb path
     *
     * @param $path
     * @return mixed
     */
    public static function makeThumbPath($path)
    {
        $path = substr_replace ($path, '/thumbs', 0, 6);
        return substr_replace ($path, '-thumb', -4, 0);
    }
}
