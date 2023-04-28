<?php

/**
 * Copyright (c) 2023-present Florent Brusciano <easygithdev@gmail.com>
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

class ImageSerializer
{

    public static function load(string $filename)
    {
        if (!file_exists($filename))
            return false;
        $content = file_get_contents($filename);
        return json_decode($content, true);
    }

    public static function write(string $filename, array $image)
    {
        $content = json_encode($image);
        return file_put_contents($filename, $content);
    }
}
