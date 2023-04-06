<?php
header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Helpers\ImageResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;

const DOWNLOAD_DIR = __DIR__ . '/download';

$image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);

$error =  [
    'error' => ['message' => '', 'type' => '', 'param' => '', 'code' => ''],
];

if (empty($image)) {
    $error['error']['message'] = 'Image is required';
    echo json_encode($error);
    die;
}

$image = __DIR__ . '/' . $image;
$filename = str_replace('.png', '', pathinfo($image, PATHINFO_FILENAME));
[,, $isize] = explode('_', $filename);
$inumber = 1;
$isize = ImageSizeEnum::tryFrom($isize) ?? ImageSizeEnum::is256;
$rformat = ImageResponseEnum::B64_JSON;

$responseArray = [
    'input' =>
    [
        'image' => $image,
        'inumber' => $inumber,
        'isize' => $isize,
        'rformat' => $rformat
    ],
    'output' => []
];

$images = [];
$apiKey = getenv('OPENAI_API_KEY');
$client = new OpenAIClient($apiKey);
try {

    $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))
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
        file_put_contents(DOWNLOAD_DIR . '/' . $filename, base64_decode($image->b64_json));
        $images[] = $filename;
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
