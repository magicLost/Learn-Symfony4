<?php

namespace NotSymfony;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\{
    ContainerBuilder,
    ContainerInterface,
    Dumper\PhpDumper,
    Loader\YamlFileLoader
};

require __DIR__.'/../vendor/autoload.php';

$cacheContainer = __DIR__.'/cached_container.php';

if(!file_exists($cacheContainer))
{
    $container = new ContainerBuilder();
    $container->setParameter('root_dir', __DIR__);

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
    $loader->load('services.yaml');

    $container->compile();

    $dumper = new PhpDumper($container);
    file_put_contents($cacheContainer, $dumper->dump());
}

require $cacheContainer;
$container = new \ProjectServiceContainer();

//run our Application
runApp($container);

function runApp(ContainerInterface $container)
{
    $logger = $container->get('logger');
    $logger->info("RUUUUUUUUUNN");
}