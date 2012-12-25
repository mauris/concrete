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

use Packfire\Concrete\BuildManager;

/**
 * Provides solid Concrete application interfacing
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete
 * @since 1.1.0
 * @link https://github.com/packfire/concrete
 */
class Concrete extends Compiler {
    
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
    public function __construct(){
        $this->loadConfig('concrete.json');
        parent::__construct($this->config->output, getcwd());
    }
    
    /**
     * Perform the loading of configuration
     * @param string $config The pathname to the configuration file
     * @since 1.1.0
     */
    protected function loadConfig($config){
        $this->config = json_decode(file_get_contents($config));
    }

    /**
     * Perform the compilation process
     * @since 1.1.0
     */
    protected function compile(){
        if(property_exists($this->config, 'alias')){
            $this->phar->setAlias($this->config->alias);
        }
        $manager = new BuildManager();
        $result = $manager->process($this->config);
        foreach($result as $entry){
            if($entry instanceof \SplFileInfo){
                echo "Adding file $entry\n";
                $this->addFile($entry);
            }elseif($entry instanceof \Packfire\Concrete\Processor\IProcessor){
                $this->processor = $entry;
            }
        }
    }
    
    /**
     * Provides the stub source code
     * @return string Returns the source code of the Phar stub
     * @since 1.1.0
     */
    protected function stub(){
        if(property_exists($this->config, 'stub') && is_file($this->config->stub)){
            return file_get_contents($this->config->stub);
        }
    }
    
}