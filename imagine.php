<?php
header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Helpers\ImageResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;


$prompt = filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_SPECIAL_CHARS);
$inumber = filter_input(INPUT_POST, 'inumber', FILTER_VALIDATE_INT);
$isize = filter_input(INPUT_POST, 'isize', FILTER_SANITIZE_SPECIAL_CHARS);
$painter = filter_input(INPUT_POST, 'painter', FILTER_SANITIZE_SPECIAL_CHARS);

$isize = ImageSizeEnum::from($isize);
$rformat = ImageResponseEnum::URL;
$prompt .= " by $painter";

$painters = [
    'Wassily Kandinsky',
    // 'Henri Matisse',
    // 'Joan Miró',
    // 'Pablo Picasso'
];

$apiKey = getenv('OPENAI_API_KEY');
$client = new OpenAIClient($apiKey);
try {

    // $response = $client
    //     ->Completion()
    //     ->create(
    //         ModelEnum::TEXT_DAVINCI_003,
    //         prompt: $prompt,
    //         temperature: 0.7,
    //         max_tokens: 100,
    //         top_p: 1.0,
    //         frequency_penalty: 0.0,
    //         presence_penalty: 1
    //     )
    //     ->toObject();

    // $summary = $response->choices[0]->text;
    $summary = $prompt;
    $images = [];
    $imageHandler = $client->Image();
    foreach ($painters as $painter) {
        $response = $imageHandler->create(
            $prompt,
            n: $inumber,
            size: $isize,
            response_format: $rformat
        )->toObject();

        foreach ($response->data as $image) {
            $images['images'][] = $image->url;
        }

        // $images[$painter][] = $image->url;
    }
} catch (Throwable $t) {
    echo nl2br($t->getMessage());
    die;
}

echo json_encode($images);
