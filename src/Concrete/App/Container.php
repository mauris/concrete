<?php
/**
* Concrete PHAR Compiler
* By Sam-Mauris Yong
*
* Released open source under New BSD 3-Clause License.
* Copyright (c) 2014, Sam-Mauris Yong <sam@mauris.sg>
* All rights reserved.
*/

namespace Concrete\App;

use Pimple\Container as Pimple;

/**
 * Build the IoC Container
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete\App
 * @since 1.2.1
 * @link https://github.com/mauris/concrete
 */
class Container
{
    public function create()
    {
        $c = new Pimple();

        $c['concrete'] = function($c) {
            return new \Concrete\Concrete();
        };

        $c['command.build'] = function($c) {
            return new \Concrete\Command\BuildCommand($c['concrete']);
        };

        $c['commands'] = function($c) {
            return array(
                $c['command.build']
            );
        };

        $c['git.version'] = function($c) {
            return new \Concrete\Processor\GitTagVersion();
        };

        $c['application'] = function ($c) {
            $versionProc = $c['git.version'];
            $application = new \Symfony\Component\Console\Application('Concrete PHAR Compiler for PHP', $versionProc->process('{{version}}'));
            $application->addCommands($c['commands']);
            return $application;
        };

        return $c;
    }
}
