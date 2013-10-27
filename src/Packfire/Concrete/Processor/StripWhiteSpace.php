<?php
/**
 * Packfire Concrete
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2013, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Packfire\Concrete\Processor;

/**
 * A processor that strips whitespaces from a PHP file
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2013 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete\Processor
 * @since 1.0.0
 * @link https://github.com/packfire/concrete
 */
class StripWhiteSpace implements ProcessorInterface
{
    /**
     * Process the source code
     * @param string $source The original source code to be processed
     * @since 1.0.0
     */
    public function process($source)
    {
        if (!function_exists('token_get_all')) {
            return $source;
        }

        $output = '';
        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                //$output .= str_repeat("\n", substr_count($token[1], "\n"));
            } elseif (T_WHITESPACE === $token[0]) {
                // reduce wide spaces
                $whitespace = preg_replace(array('{[ \t]+}', '{(\r\n|\r|\n)}', '{\n +}'), array(' ', "\n", "\n"), $token[1]);
                $output .= $whitespace;
            } else {
                $output .= $token[1];
            }
        }

        return $output;
    }
}
