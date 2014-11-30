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

use Symfony\Component\Process\Process;

/**
 * A processor that fetch the version from Git tag and replace source code with actual versions
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete\Processor
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
class GitTagVersion implements ProcessorInterface
{
    /**
    * Fetches the version number from Git
    * @throws \RuntimeException Thrown when "git" cannot be executed.
    * @since 1.2.1
    */
    protected function getVersion()
    {
        $version = '';
        $processTag = new Process('git describe --tags HEAD');
        if ($processTag->run() == 0) {
            $version = trim(strtok($processTag->getOutput(), "\n"));
        }

        if (!$version) {
            $process = new Process('git log --pretty="%h" -n1 HEAD');
            if ($process->run() != 0) {
                throw new \RuntimeException('Can\'t run "git log". Git must be installed and you must compile from a local git repository.');
            }
            $version = trim($process->getOutput());
        }
        return $version;
    }

    /**
     * Process the source code
     * @param string $source The original source code to be processed
     * @since 1.0.1
     */
    public function process($source)
    {
        if (strpos($source, '{{' . 'version' . '}}') !== false) {
            $version = $this->getVersion();
            if ($version) {
                // the breaking up of the version string is to prevent it from being parsed
                // during self-compilation.
                $source =  str_replace('{{'.'version'.'}}', $version, $source);
            }
        }
        return $source;
    }
}
