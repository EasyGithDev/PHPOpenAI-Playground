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
require __DIR__ . '/../classes/ImageSerializer.php';
require __DIR__ . '/../classes/ImageIO.php';

$responseArray = [
    'success' => false,
    'output' => []
];

$filename = filter_input(INPUT_POST, 'filename', FILTER_SANITIZE_SPECIAL_CHARS);
$prompt = filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_SPECIAL_CHARS);
$inumber = filter_input(INPUT_POST, 'inumber', FILTER_VALIDATE_INT);
$isize = filter_input(INPUT_POST, 'isize', FILTER_SANITIZE_SPECIAL_CHARS);
$painter = filter_input(INPUT_POST, 'painter', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($filename)) {
    $responseArray['error'] = 'Image is required';
    echo json_encode($responseArray);
    die;
}

$image = $config['downloadDir'] . '/' . $filename;
$isize = ImageSizeEnum::tryFrom($isize) ?? ImageSizeEnum::is256;
$rformat = ImageResponseEnum::B64_JSON;

$input = [

    'prompt' => $prompt,
    'isize' => $isize,
    'inumber' => $inumber,
    'rformat' => $rformat,
    'painter' => $painter

];

$apiKey = $config['apiKey'];
$images = [];
try {

    $response = (new OpenAIClient($apiKey))
        ->Image()
        ->addCurlParam('timeout', $config['timeout'])
        ->createVariation(
            $image,
            n: $inumber,
            size: $isize,
            response_format: $rformat
        )
        ->toObject();

    foreach ($response->data as $image) {

        $id = uniqid("img_");
        $imgFilename =  $id . '_' . $isize->value . '.png';
        $jsonFilename =  $id . '_' . $isize->value . '.json';

        $input['filename'] =  $imgFilename;

        if (!ImageIO::write($config['downloadDir'] . '/' . $imgFilename, $image->b64_json))
            throw new Exception("Image write fail");

        if (!ImageSerializer::write($config['serializeDir'] . '/' . $jsonFilename, $input))
            throw new Exception("Serialize fail");

        $images[] = $input;
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
