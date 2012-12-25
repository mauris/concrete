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
 * Provides an interface for processors
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete\Processor
 * @since 1.0.0
 * @link https://github.com/packfire/concrete
 */

interface IProcessor {
    
    /**
     * Process the source code
     * @param string $source The original source code to be processed
     * @since 1.0.0
     */
    public function process(string $source);
    
}
