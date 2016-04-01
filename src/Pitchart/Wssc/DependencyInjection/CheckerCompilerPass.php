<?php

namespace Pitchart\Wssc\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class CheckerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('wssc.checker_chain')) {
            return;
        }

        $definition = $container->findDefinition(
            'wssc.checker_chain'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'wssc.checker.curl'
        );
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addCurlCheck',
                    array(new Reference($id), $attributes['type'], $attributes['alias'])
                );
            }
        }
    }
}