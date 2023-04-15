<?php
header('Content-Type: application/json');

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

if (empty($url)) {
    echo json_encode(['succes' => false, 'filename' => '']);
    die;
}

$path = parse_url($url, PHP_URL_PATH);
$filename = basename($path);
$content = file_get_contents($url);
file_put_contents(__DIR__ . "/download/$filename", $content);

echo json_encode(['succes' => true, 'filename' => $filename]);
