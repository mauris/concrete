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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console Command for about
 *
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2014 Sam-Mauris Yong <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Concrete\Command
 * @since 1.2.1
 * @link https://github.com/mauris/concrete
 */
class AboutCommand extends Command
{
    protected function configure()
    {
        $this->setName('about')
            ->setDescription('Some information about Concrete')
            ->setHelp(
                <<<EOT
<info>concrete about</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            <<<EOT
<info>Concrete - PHAR Compiler for PHP</info>
<comment>
   ____                          _       
  / ___|___  _ __   ___ _ __ ___| |_ ___ 
 | |   / _ \| '_ \ / __| '__/ _ \ __/ _ \
 | |__| (_) | | | | (__| | |  __/ ||  __/
  \____\___/|_| |_|\___|_|  \___|\__\___|
</comment>
<comment>Concrete compiles your application neatly into PHAR binaries with the processing power you need.

For more information, visit https://github.com/mauris/concrete</comment>
EOT
        );
    }
}
