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

foreach (new DirectoryIterator($config['downloadDir']) as $file) {
    if ($file->getExtension() == 'png') {
        $jsonFilename = $config['serializeDir'] . '/' . str_replace('.png', '.json', $file->getFilename());
        $infos = ImageSerializer::load($jsonFilename);
        if ($infos) {
            $images[] = $infos;
        }
    }
}

$responseArray['success'] = true;
$responseArray['output'] = $images;

echo json_encode($responseArray);
