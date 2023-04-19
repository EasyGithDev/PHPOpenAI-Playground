<?php
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

$prompt = filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_SPECIAL_CHARS);
$inumber = filter_input(INPUT_POST, 'inumber', FILTER_VALIDATE_INT);
$isize = filter_input(INPUT_POST, 'isize', FILTER_SANITIZE_SPECIAL_CHARS);
$painter = filter_input(INPUT_POST, 'painter', FILTER_SANITIZE_SPECIAL_CHARS);
$debug = filter_input(INPUT_POST, 'debug', FILTER_VALIDATE_BOOL);

if (empty($prompt)) {
    $responseArray['error'] = 'Prompt is required';
    echo json_encode($responseArray);
    die;
}

if ($inumber < 1 || $inumber > 4) {
    $responseArray['error'] = 'Number of frames is between 1 and 4';
    echo json_encode($responseArray);
    die;
}

$isize = ImageSizeEnum::tryFrom($isize) ?? ImageSizeEnum::is256;
$rformat = ImageResponseEnum::B64_JSON;
$by = empty($painter) ? '' : " by $painter";
$prompt .= $by;

$responseArray['input'] = [
    'prompt' => $prompt,
    'isize' => $isize,
    'inumber' => $inumber,
    'rformat' => $rformat,
    'painter' => $painter
];

if ($debug) {
    $responseArray['output'][] = 'php-logo-bigger.png';
    echo json_encode($responseArray);
    die;
}

$apiKey = $config['apiKey'];
$images = [];
try {
    $response = (new OpenAIClient($apiKey))
        ->Image()
        ->create(
            $prompt,
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