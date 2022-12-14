<?php

namespace Partitech\AdvancedFormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DependentEntityMapperPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('partitech_afb.dependent_entity.mapper_pool');
        $taggedServices = $container->findTaggedServiceIds('partitech_afb.dependent_entity_mapper');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addMapper', [new Reference($id)]);
        }
    }
}
