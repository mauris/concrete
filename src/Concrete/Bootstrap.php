<?php
/**
 * Concrete PHAR Compiler
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2014, Sam-Mauris Yong <sam@mauris.sg>
 * All rights reserved.
 */

namespace Concrete;

/**
 * Bootstrapper for ensuring that composer is installed
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
class Bootstrap
{
    private static function acquire($file)
    {
        if (is_file($file)) {
            return include($file);
        }
    }

    private static function getLoader()
    {
        $files = array(
            dirname(dirname(dirname(__DIR__))) . '/autoload.php',
            dirname(dirname(__DIR__)) . '/vendor/autoload.php'
        );
        foreach ($files as $file) {
            if ($loader = self::acquire($file)) {
                return $loader;
            }
        }
        return false;
    }

    public static function run()
    {
        if (!($loader = self::getLoader())) {
            echo 'You must set up project\'s dependencies first by running the following commands:' . PHP_EOL;
            echo "    curl -s https://getcomposer.org/installer | php\n";
            echo "    php composer.phar install\n";
            exit(1);
        }
        return $loader;
    }
}

return Bootstrap::run();
