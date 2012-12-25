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

use Symfony\Component\Finder\Finder;

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
class Concrete extends Compiler{
    
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
        $this->processBuildSet($this->config);
    }
    
    /**
     * Process a build set recursively
     * @param object $set The build configuration set
     * @since 1.1.0
     */
    protected function processBuildSet($set){
        foreach($set->build as $entry){
            if(is_object($entry)){
                $this->processBuildSet($entry);
            }else{
                $find = new Finder();
                if(is_dir($entry)){
                    $find->files()
                         ->in($entry);
                }elseif(is_file($entry)){
                    $find->files()
                         ->depth('== 0')
                         ->name(basename($entry))
                         ->in(dirname($entry));
                }else{
                    $find = array();
                }
                foreach($find as $file){
                    $this->addFile($file);
                }
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