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

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Helpers\ImageResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;

$config = require __DIR__ . '/../config/conf.php';

$responseArray = [
    'success' => false,
    'input' => [],
    'output' => []
];

$image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($image)) {
    $responseArray['error'] = 'Image is required';
    echo json_encode($responseArray);
    die;
}

$image = __DIR__ . '/' . $image;
$filename = str_replace('.png', '', pathinfo($image, PATHINFO_FILENAME));
[,, $isize] = explode('_', $filename);
$inumber = 1;
$isize = ImageSizeEnum::tryFrom($isize) ?? ImageSizeEnum::is256;
$rformat = ImageResponseEnum::B64_JSON;

$responseArray['input'] = [

    'image' => $image,
    'inumber' => $inumber,
    'isize' => $isize,
    'rformat' => $rformat

];

$apiKey = $config['apiKey'];
$images = [];
try {

    $response = (new OpenAIClient($apiKey))
        ->Image()
        ->createVariation(
            $image,
            n: $inumber,
            size: $isize,
            response_format: $rformat
        )
        ->toObject();

    foreach ($response->data as $image) {
        $filename = uniqid("img_") . '_' . $isize->value . '.png';
        file_put_contents($config['downloadDir'] . '/' . $filename, base64_decode($image->b64_json));
        $images[] = $filename;
    }
} catch (ApiException $e) {
    $responseArray['error'] = $e->getMessage();
    echo json_encode($responseArray);
    die;
} catch (Throwable $t) {
    $responseArray['error'] = $t->getMessage();
    echo json_encode($responseArray);
    die;
}

$responseArray['success'] = true;
$responseArray['output'] = $images;

echo json_encode($responseArray);
