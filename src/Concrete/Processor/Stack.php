<?php
/**
 * Concrete PHAR Compiler
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2014, Sam-Mauris Yong <sam@mauris.sg>
 * All rights reserved.
 */

namespace Concrete\Processor;

/**
 * A stack of processors
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete\Processor
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
class Stack implements ProcessorInterface
{
    /**
     * The collection of processors
     * @var array
     * @since 1.0.0
     */
    private $processors = array();

    /**
     * Create a new Stack object
     * @param array|\Concrete\Processor\IProcessor $processor,... An arbituary number of processors to stack up
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->processors = func_get_args();
        if (count($this->processors) == 1 && is_array($this->processors[0])) {
            $this->processors = $this->processors[0];
        }
    }

    /**
     * Push a processor onto the stack
     * @param \Concrete\Processor\IProcessor $processor The processor to be added
     * @since 1.1.0
     */
    public function push(ProcessorInterface $processor)
    {
        array_push($this->processors, $processor);
    }

    /**
     * Pop the last pushed processor off the stack
     * @return \Concrete\Processor\IProcessor Returns the processor removed
     * @since 1.1.0
     */
    public function pop()
    {
        return array_pop($this->processors);
    }

    /**
     * Process the source code
     * @param string $source The original source code to be processed
     * @since 1.0.0
     */
    public function process($source)
    {
        foreach ($this->processors as $processor) {
            $source = $processor->process($source);
        }
        return $source;
    }
}
