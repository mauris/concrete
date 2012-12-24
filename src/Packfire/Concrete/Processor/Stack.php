<?php

/**
 * Packfire Concrete
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Packfire\Concrete\Processor;

/**
 * A stack of processors
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete\Processor
 * @since 1.0.0
 * @link https://github.com/packfire/concrete
 */

class Stack implements IProcessor {

	private $processors = array();

	public function __construct(IProcessor $processor){
		$this->processors = func_get_args();
	}
    
    public function process($source){
        foreach($this->processors as $processor){
        	$source = $processor->process($source);
        }
        return $source;
    }
    
}
