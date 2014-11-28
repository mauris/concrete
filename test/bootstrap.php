<?php
/**
 * Concrete PHAR Compiler
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2014, Sam-Mauris Yong <sam@mauris.sg>
 * All rights reserved.
 */

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    $loader = require(__DIR__ . '/../vendor/autoload.php');
    $loader->add('Concrete\\', __DIR__);
} else {
    echo 'Oops... think you forgot to do a `composer install`. We couldn\'t find the autoloader.' . "\n";
}
