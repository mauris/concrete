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
 * A processor that lets the file show distinctively in the source code of the PHAR
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete\Processor
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
class License implements ProcessorInterface
{
    /**
     * Process the source code
     * @param string $source The original source code to be processed
     * @since 1.0.0
     */
    public function process($source)
    {
        return "\n\n$source\n\n";
    }
}
