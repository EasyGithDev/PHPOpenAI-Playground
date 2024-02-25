<?php
return [
    'apiKey' => getenv('OPENAI_API_KEY'),
    'downloadDir' => __DIR__ . '/../download',
    'serializeDir' => __DIR__ . '/../serialize',
    'dalleVersion' => 2,
    'timeout' => 30
];
