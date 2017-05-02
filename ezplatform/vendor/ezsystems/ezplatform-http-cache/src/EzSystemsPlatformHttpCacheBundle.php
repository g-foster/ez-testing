<?php

namespace EzSystems\PlatformHttpCacheBundle;

use EzSystems\PlatformHttpCacheBundle\DependencyInjection\Compiler\ResponseTaggersPass;
use EzSystems\PlatformHttpCacheBundle\DependencyInjection\Compiler\KernelPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EzSystemsPlatformHttpCacheBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ResponseTaggersPass());
        $container->addCompilerPass(new KernelPass());
    }
}
