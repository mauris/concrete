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
     * The current processors
     * @var array
     * @since 1.1.0
     */
    private $processor;
    
    /**
     * The current working set
     * @var object
     * @since 1.1.1
     */
    private $set;
    
    /**
     * Create a new BuildManager object
     */
    public function __construct($set, $processors = array()){
        $this->set = $set;
        $this->processor = $processors;
    }
    
    /**
     * Process a build set
     * @param object $set The build configuration set
     * @return array Returns the complete process set
     * @since 1.1.0
     */
    public function process(){
        $result = array();
        if(property_exists($this->set, 'processor')){
            $this->processor += $this->pushProcessor($this->set->processor);
            $result[] = new Stack($this->processor);
        }
        foreach($this->set->build as $entry){
            if(is_object($entry)){
                $subManager = new BuildManager($entry, $this->processor);
                $result = array_merge($result, $subManager->process());
                $result[] = new Stack($this->processor);
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
                    $result[] = $file;
                }
            }
        }
        return $result;
    }
    
    /**
     * Process and processor tree recursively
     * @param mixed $processor The processor data set
     * @since 1.1.0
     */
    protected function pushProcessor($processor){
        $processors = array();
        if(is_string($processor)){
            $processor = (object)array(
                'name' => $processor
            );
        }
        if(is_array($processor)){
            foreach($processor as $entry){
                $processors = array_merge($processors, $this->pushProcessor($entry));
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
                $processors[] = $instance;
            }
        }
        return $processors;
    }
    
}