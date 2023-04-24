<?php

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
