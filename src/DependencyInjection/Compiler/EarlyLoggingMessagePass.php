<?php

namespace App\DependencyInjection\Compiler;


use App\Test\Test;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EarlyLoggingMessagePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(Test::class);
        $definition->addMethodCall('dump', ['Test created, m f']);
    }
}