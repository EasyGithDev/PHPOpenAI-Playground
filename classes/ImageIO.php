<?php

/**
 * Copyright (c) 2023-present Florent Brusciano <easygithdev@gmail.com>
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

class ImageIO
{

    // public static function load(string $filename)
    // {
    //     if (!file_exists($filename))
    //         return false;
    //     $content = file_get_contents($filename);
    //     return $content;
    // }

    public static function gdWrite(string $filename, string $data)
    {
        $im = imagecreatefromstring(base64_decode($data));
        if (!$im) {
            return false;
        }
        if (!imagepng($im, $filename, 0))
            return false;

        if (!imagedestroy($im)) {
            return false;
        }

        return true;
    }

    public static function rawWrite(string $filename, string $data)
    {
        return file_put_contents($filename, base64_decode($data));
    }

    public static function write(string $filename, string $data)
    {
        // if (extension_loaded('gd')) {
        //     return static::gdWrite($filename, $data);
        // }

        return static::rawWrite($filename, $data);
    }
}
