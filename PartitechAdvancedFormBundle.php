<?php

namespace Partitech\AdvancedFormBundle;

use Partitech\AdvancedFormBundle\DependencyInjection\Compiler\DependentEntityMapperPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PartitechAdvancedFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DependentEntityMapperPass());
    }
}
