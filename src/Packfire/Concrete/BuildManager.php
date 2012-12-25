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
use Packfire\Concrete\Processor\Stack;

/**
 * Build Set Management
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete
 * @since 1.1.0
 * @link https://github.com/packfire/concrete
 */
class BuildManager{
    
    /**
     * Processed build set result
     * @var array
     * @since 1.1.0
     */
    private $result;
    
    /**
     * The current processors
     * @var array
     * @since 1.1.0
     */
    private $processor;
    
    /**
     * Create a new BuildManager object
     */
    public function __construct(){
        $this->processor = array();
    }
    
    /**
     * Process a build set
     * @param object $set The build configuration set
     * @return array Returns the complete process set
     * @since 1.1.0
     */
    public function process($set){
        $this->result = array();
        $this->processBuildSet($set);
        return $this->result;
    }
    
    /**
     * Process and processor tree recursively
     * @param mixed $processor The processor data set
     * @since 1.1.0
     */
    protected function pushProcessor($processor){
        $count = 0;
        if(is_string($processor)){
            $processor = (object)array(
                'name' => $processor
            );
        }
        if(is_array($processor)){
            foreach($processor as $entry){
                $this->pushProcessor($entry);
            }
        }else{
            if(property_exists($processor, 'name') && $processor->name){
                $instance = null;
                if(property_exists($processor, 'args')){
                    $reflection = new \ReflectionClass($processor->name);
                    $instance = $reflection->newInstanceArgs($processor->args);
                }else{
                    $name = $processor->name;
                    $instance = new $name();
                }
                array_push($this->processor, $instance);
                ++$count;
            }
        }
        return $count;
    }
    
    /**
     * Process a build set recursively
     * @param object $set The build configuration set
     * @since 1.1.0
     */
    protected function processBuildSet($set){
        $processorCount = 0;
        if(property_exists($set, 'processor')){
            $processorCount = $this->pushProcessor($set->processor);
        }
        $this->result[] = new Stack($this->processor);
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
                    $this->result[] = $file;
                }
            }
        }
        for($i = 0; $i < $processorCount; ++$i){
            array_pop($this->processor);
        }
    }
    
}