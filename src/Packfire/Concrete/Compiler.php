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

use Symfony\Component\Process\Process;

/**
 * Helps to provide compilation into a PHAR binary
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete
 * @since 1.0.0
 * @link https://github.com/packfire/concrete
 */
abstract class Compiler {
    
    protected $version;
    
    protected $phar;
    
    protected $processor;

    public function __construct($file){
        if(is_file($file)){
            @unlink($file);
        }
        $this->phar = new \Phar($file, 0, basename($file));
    }
    
    protected abstract function compile();

    public function build(){
        $this->loadVersion();
        $this->phar->setSignatureAlgorithm(\Phar::SHA1);
        $this->compile();
        if($stub = $this->stub()){
            $this->phar->setStub($stub);
        }
    }
    
    protected function addFolder($folder){
        $iterator = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($folder),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
        foreach($iterator as $path){
            $this->addFile($path);
        }
    }
    
    protected function addFile($file) {
        if($file->getRealPath() == __DIR__){
            return;
        }

        $path = str_replace(
                dirname(dirname($_SERVER['SCRIPT_NAME'])) . DIRECTORY_SEPARATOR,
                '', $file->getRealPath());
        $content = file_get_contents($file);
        $content = preg_replace('{^#!/usr/bin/env php\s*}', '', $content);
        $content = str_replace('{{version}}', $this->version, $content);

        $this->phar->addFromString($path, $content);
    }
    
    protected function stub(){

    }
    
    protected function loadVersion(){
        $process = new Process('git log --pretty="%h" -n1 HEAD', __DIR__);
        if ($process->run() != 0) {
            throw new \RuntimeException('Can\'t run "git log". You must compile from git repository clone and that git binary is installed.');
        }
        $this->version = trim($process->getOutput());

        $processTag = new Process('git describe --tags HEAD');
        if ($processTag->run() == 0) {
            $this->version = trim($processTag->getOutput());
        }
    }
    
}
