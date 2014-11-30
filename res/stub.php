#!/usr/bin/env php
<?php
/**
 * Concrete PHAR Compiler
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2014, Sam-Mauris Yong <sam@mauris.sg>
 * All rights reserved.
 */

Phar::mapPhar('concrete.phar');
require 'phar://concrete.phar/bin/concrete';

__HALT_COMPILER();
