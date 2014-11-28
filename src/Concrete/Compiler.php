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

use Concrete\Processor\ProcessorInterface;

/**
 * Helps to provide compilation into a PHAR binary
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
abstract class Compiler
{
    /**
     * The original Phar object
     * @var \Phar
     * @since 1.0.0
     */
    protected $phar;

    /**
     * The current processor that processes the file.
     * If there is no processor, this is set to null.
     * @var \Packfire\Concrete\Processor\IProcessor
     * @since 1.0.0
     */
    protected $processor;

    /**
     * The root directory to work from
     * @var string
     * @since 1.0.0
     */
    protected $root;

    /**
     * The file path name
     * @var string
     * @since 1.2.0
     */
    protected $file;

    /**
     * Create a new Compiler object
     * @param string $file The pathname to the output phar file
     * @param string $root The path of the root directory to build the phar file
     *                     from.
     * @since 1.0.0
     */
    public function __construct($file, $root = null)
    {
        if (is_file($file)) {
            @unlink($file);
        }
        $this->root = $root;
        if (!$this->root) {
            $this->root = dirname(dirname($_SERVER['SCRIPT_NAME'])) . DIRECTORY_SEPARATOR;
        }
        $this->file = $file;
    }

    /**
     * Perform environment check and output and error message.
     * @return boolean Returns true if the check is fine, false otherwise.
     * @since 1.0.0
     */
    protected function checkEnvironment()
    {
        $result = true;
        $check = ini_get('phar.readonly');
        if ($check) {
            echo "Fatal Error: Concrete will not be able to compile PHAR files because the php.ini setting 'phar.readonly' is turned on. \n\nPlease turn off the setting before compiling.\n\n";
            $result = false;
        }
        return $result;
    }

    /**
     * Override this method to perform the compilation actions.
     * @since 1.0.0
     */
    abstract protected function compile();

    /**
     * Build the Phar binary
     * @return boolean Returns true if the build is successful, false otherwise.
     * @since 1.0.0
     */
    public function build()
    {
        if ($this->checkEnvironment()) {
            $this->phar = new \Phar($this->file, 0, basename($this->file));
            $this->phar->setSignatureAlgorithm(\Phar::SHA1);
            $this->compile();
            $stub = $this->stub();
            if ($stub) {
                $this->phar->setStub($stub);
            }
            return true;
        }
        return false;
    }

    /**
     * Add a file into the Phar binary
     * @param \SplFileInfo $file The file to be added
     * @since 1.0.0
     */
    protected function addFile(\SplFileInfo $file)
    {
        $path = str_replace(
            $this->root,
            '',
            $file->getRealPath()
        );
        $content = file_get_contents($file);
        $content = preg_replace('{^#!/usr/bin/env php\s*}', '', $content);
        if ($this->processor instanceof ProcessorInterface) {
            $content = $this->processor->process($content);
        }

        $this->phar->addFromString($path, $content);
    }

    /**
     * Override this method to provide a stub for the Phar file
     * @return string Returns the source code of the Phar stub
     * @since 1.0.0
     */
    protected function stub()
    {
    }
}
