<?php

/**
 * Copyright (c) 2023-present Florent Brusciano <easygithdev@gmail.com>
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

$config = require __DIR__ . '/../config/conf.php';

header('Content-Type: image/png');

$filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($filename)) {
    $fp = fopen("https://www.php.net/images/logos/php-logo-bigger.png", 'rb');

    // dump the picture and stop the script
    fpassthru($fp);
} else {
    $image = $config['downloadDir'] . '/' . $_GET['filename'];
    readfile($image);
}
