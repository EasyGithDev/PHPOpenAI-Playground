<?php
return [
    'apiKey' => getenv('OPENAI_API_KEY'),
    'downloadDir' => __DIR__ . '/../download',
    'serializeDir' => __DIR__ . '/../serialize',
    'timeout' => 30
];
