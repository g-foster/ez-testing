<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\PlatformHttpCacheBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Disables some of the http-cache services declared by the kernel so that
 * they can be replaced with this bundle's.
 */
class KernelPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($this->isSignalSlot($id) ||
                $this->isSmartCacheListener($id) ||
                $this->isResponseCacheListener($id)
            ) {
                $container->removeDefinition($id);
            }
        }
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    protected function isSignalSlot($id)
    {
        return strpos($id, 'ezpublish.http_cache.signalslot.') === 0;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    protected function isSmartCacheListener($id)
    {
        return preg_match('/^ezpublish\.cache_clear\.content.[a-z_]+_listener/', $id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    protected function isResponseCacheListener($id)
    {
        return $id === 'ezpublish.view.cache_response_listener';
    }
}
