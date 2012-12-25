<?php

/**
 * Packfire Concrete
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Packfire\Concrete;

/**
 * Bootstrapper for ensuring that composer is installed
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete
 * @since 1.1.0
 * @link https://github.com/packfire/concrete
 */
class Bootstrap {

    private static function acquire($file) {
        if (is_file($file)) {
            return include($file);
        }
    }

    public static function run() {
        if (!($loader = self::acquire(__DIR__ . '/../../../vendor/autoload.php'))) {
            echo 'You must set up project\'s dependencies first by running the following commands:' . PHP_EOL;
            echo "    curl -s https://getcomposer.org/installer | php\n";
            echo "    php composer.phar install\n";
            exit(1);
        }
        return $loader;
    }

}

return Bootstrap::run();

