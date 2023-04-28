<?php

/**
 * Copyright (c) 2023-present Florent Brusciano <easygithdev@gmail.com>
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/conf.php';

$responseArray = [
    'success' => false,
    'output' => []
];

require __DIR__ . '/../classes/ImageSerializer.php';
$images = [];
$files = [];
$mtimes = [];
$dir = new DirectoryIterator($config['serializeDir']);

foreach ($dir as $file) {
    if (!$file->isFile() or $file->getExtension() != 'json')
        continue;

    $mtime = $file->getMTime();

    if (!isset($mtimes[$mtime])) {
        $files[$mtime . '.0'] = $file->getFilename();
        $mtimes[$mtime] = 1;
    } else {
        $files[$mtime . '.' . $mtimes[$mtime]++] = $file->getFilename();
    }
}

ksort($files);

foreach ($files as $filename) {
    $jsonFilename = $config['serializeDir'] . '/' . $filename;
    $infos = ImageSerializer::load($jsonFilename);
    if ($infos) {
        $images[] = $infos;
    }
}

$responseArray['success'] = true;
$responseArray['output'] = $images;

echo json_encode($responseArray);
