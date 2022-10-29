#!/usr/bin/env php
<?php
// orchestra.php

require __DIR__.'/vendor/autoload.php';

use PhpOrchestra\Cli\Commands\Solution\InitializeCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new InitializeCommand());

$application->run();