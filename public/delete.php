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
require __DIR__ . '/../classes/ImageSerializer.php';

$responseArray = [
    'success' => false,
    'output' => []
];

$filename = filter_input(INPUT_POST, 'filename', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($filename)) {
    $responseArray['error'] = 'Image is required';
    echo json_encode($responseArray);
    die;
}

$image = str_replace('.png', '', $filename);
$imageFileName = $config['downloadDir'] . '/' . $image . '.png';
$jsonFilename = $config['serializeDir'] . '/' . $image .'.json';

if(!is_writable($imageFileName)) {
    $responseArray['error'] = 'Unable to delete image';
    echo json_encode($responseArray);
    die;
}

if(!is_writable($jsonFilename)) {
    $responseArray['error'] = 'Unable to delete image';
    echo json_encode($responseArray);
    die;
}

if(!unlink($imageFileName)) {
    $responseArray['error'] = 'Unable to delete image';
    echo json_encode($responseArray);
    die;
}

if(!unlink($jsonFilename)){
    $responseArray['error'] = 'Unable to deleted serialized data';
    echo json_encode($responseArray);
    die;
}

$responseArray['success'] = true;
$responseArray['output'] = ['image' => $image];

echo json_encode($responseArray);
