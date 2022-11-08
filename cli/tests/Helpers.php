<?php

use PhpOrchestra\Cli\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

function buildOrchestraContainer()
{
    $containerBuilder = new ContainerBuilder();
    $loader = new YamlFileLoader(
        $containerBuilder,
        new FileLocator(__DIR__.'/../config')
    );
    $loader->load('services.yaml');

    $containerBuilder->compile();

    return $containerBuilder;
}

function getApplication(): Application
{
    $containerBuilder = buildOrchestraContainer();

    return $containerBuilder->get(Application::class);
}
