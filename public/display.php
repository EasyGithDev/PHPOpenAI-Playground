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
    'input' => [],
    'output' => []
];

$images = [];

foreach (new DirectoryIterator($config['downloadDir']) as $file) {
    if($file->getExtension() == 'png') {
        $images[] = $file->getFilename();
    }
}

$responseArray['success'] = true;
$responseArray['output'] = $images;

echo json_encode($responseArray);
