<?php
/**
 * Concrete PHAR Compiler
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2014, Sam-Mauris Yong <sam@mauris.sg>
 * All rights reserved.
 */

namespace Concrete\Command;

use Concrete\Concrete;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console Command for performing a build operation
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete\Command
 * @since 1.2.0
 * @link https://github.com/mauris/concrete
 */
class BuildCommand extends Command
{
    private $concrete;

    public function __construct($concrete)
    {
        $this->concrete = $concrete;
    }

    protected function configure()
    {
        $this->setName('build')
            ->setDescription('Perform a build operation in the current working directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->concrete->build();
    }
}
