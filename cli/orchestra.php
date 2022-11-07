#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use PhpOrchestra\Cli\Application;
use PhpOrchestra\Cli\Commands\Solution\InitializeCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader(
    $containerBuilder, 
    new FileLocator(__DIR__.'/config')
);
$loader->load('services.yaml');

$containerBuilder->compile();

exit($containerBuilder->get(Application::class)->run());
