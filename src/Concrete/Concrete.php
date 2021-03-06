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

use Concrete\BuildManager;
use Concrete\Processor\ProcessorInterface;

/**
 * Provides solid Concrete application interfacing
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
class Concrete extends Compiler
{
    /**
     * The configuration loaded from the JSON file
     * @var object
     * @since 1.1.0
     */
    protected $config;

    /**
     * Create a new Concrete object
     * @since 1.1.0
     */
    public function __construct()
    {
        $this->loadConfig('concrete.json');
        parent::__construct($this->config->output, getcwd());
    }

    /**
     * Perform the loading of configuration
     * @param string $config The pathname to the configuration file
     * @since 1.1.0
     */
    protected function loadConfig($config)
    {
        if (file_exists($config)) {
            $this->config = json_decode(file_get_contents($config));
        } else {
            throw new RuntimeException('The concrete.json build file could not be found in the current directory');
        }
    }

    /**
     * Perform the compilation process
     * @since 1.1.0
     */
    protected function compile()
    {
        echo "Concrete v{{version}}\nSam-Mauris Yong\n\n";
        if (property_exists($this->config, 'alias')) {
            echo "Setting PHAR alias to " . $this->config->alias . "\n\n";
            $this->phar->setAlias($this->config->alias);
        }
        echo "Compiling PHAR binary...\n";
        $manager = new BuildManager($this->config);
        $result = $manager->process();
        foreach ($result as $entry) {
            if ($entry instanceof \SplFileInfo) {
                echo " + $entry\n";
                $this->addFile($entry);
            } elseif ($entry instanceof ProcessorInterface) {
                $this->processor = $entry;
            }
        }
        echo "\nComplete.\n";
    }

    /**
     * Provides the stub source code
     * @return string Returns the source code of the Phar stub
     * @since 1.1.0
     */
    protected function stub()
    {
        if (property_exists($this->config, 'stub') && is_file($this->config->stub)) {
            return file_get_contents($this->config->stub);
        }
    }
}
