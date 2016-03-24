<?php
/**
 * This file is part of `oanhnn/demo-phpunit-calculator` project.
 *
 * (c) 016 Oanh Nguyen
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

// Set timezone
date_default_timezone_set('UTC');

// Enable Composer autoloader
/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';

// Register test classes
$autoloader->addPsr4('Demo\\Calculator\\Tests\\', __DIR__);
