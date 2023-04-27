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

$image = $config['downloadDir'] . '/' . $_GET['filename'];

readfile($image);
