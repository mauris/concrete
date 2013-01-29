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

use Symfony\Component\Process\Process;

/**
 * A processor that fetch the version from Git tag and replace source code with actual versions
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete\Processor
 * @since 1.0.1
 * @link https://github.com/packfire/concrete
 */
class GitTagVersion implements IProcessor {

    /**
     * The version number fetched from the Git repository
     * @var string
     * @since 1.0.1
     */
    private $version;

    /**
     * Create a new GitTagVersion object
     * @throws \RuntimeException Thrown when "git log" cannot be executed.
     * @since 1.0.1
     */
    public function __construct(){
        $process = new Process('git log --pretty="%h" -n1 HEAD');
        if ($process->run() != 0) {
            throw new \RuntimeException('Can\'t run "git log". Git must be executable and you must compile from a git repository clone.');
        }
        $this->version = trim($process->getOutput());

        $processTag = new Process('git describe --tags HEAD');
        if ($processTag->run() == 0) {
            $this->version = trim($processTag->getOutput());
        }
    }
    
    /**
     * Process the source code
     * @param string $source The original source code to be processed
     * @since 1.0.1
     */
    public function process($source){
    	if($this->version){
            $source =  str_replace('{{version}}', $this->version, $source);
    	}
    	return $source;
    }
    
}
