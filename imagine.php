<?php
header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Helpers\ImageResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;


$prompt = filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_SPECIAL_CHARS);
$inumber = filter_input(INPUT_POST, 'inumber', FILTER_VALIDATE_INT);
$isize = filter_input(INPUT_POST, 'isize', FILTER_SANITIZE_SPECIAL_CHARS);
$painter = filter_input(INPUT_POST, 'painter', FILTER_SANITIZE_SPECIAL_CHARS);
$debug = filter_input(INPUT_POST, 'debug', FILTER_VALIDATE_BOOL);

$error =  [
    'error' => ['message' => '', 'type' => '', 'param' => '', 'code' => ''],
];

if (empty($prompt)) {
    $error['error']['message'] = 'Prompt is required';
    echo json_encode($error);
    die;
}

if ($inumber < 1 || $inumber > 4) {
    $error['error']['message'] = 'Number of frames is between 1 and 4';
    echo json_encode($error);
    die;
}

$isize = ImageSizeEnum::tryFrom($isize) ?? ImageSizeEnum::is256;
$rformat = ImageResponseEnum::URL;
$by = empty($painter) ? '' : " by $painter";
$prompt .= $by;

$responseArray = [
    'input' =>
    [
        'prompt' => $prompt,
        'isize' => $isize,
        'rformat' => $rformat,
        'painter' => $painter
    ],
    'output' => []
];

if ($debug) {
    $responseArray['output'][] = 'https://www.php.net/images/logos/php-logo-bigger.png';
    echo json_encode($responseArray);
    die;
}

$images = [];
$apiKey = getenv('OPENAI_API_KEY');
$client = new OpenAIClient($apiKey);
try {
    $imageHandler = $client->Image();
    $response = $imageHandler->create(
        $prompt,
        n: $inumber,
        size: $isize,
        response_format: $rformat
    )->toObject();

    foreach ($response->data as $image) {
        $images[] = $image->url;
    }
} catch (ApiException $e) {
    $error['error']['message'] = $e->getMessage();
    echo json_encode($error);
    die;
} catch (Throwable $t) {
    $error['error']['message'] = $t->getMessage();
    echo json_encode($error);
    die;
}

$responseArray['output'] = $images;

echo json_encode($responseArray);
