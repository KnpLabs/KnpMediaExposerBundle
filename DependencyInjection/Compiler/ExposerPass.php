<?php

namespace Knp\Bundle\MediaExposerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * The exposer pass is responsible of finding the services having the
 * "media_exposer.resolver" tag and register them to the "media_exposer"
 * service.
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class ExposerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('media_exposer')) {
            return;
        }

        $definition = $container->getDefinition('media_exposer');
        foreach ($container->findTaggedServiceIds('knp_media_exposer.resolver') as $id => $tag) {
            $definition->addMethodCall(
                'addResolver',
                array(
                    new Reference($id),
                    isset($tag['priority']) ? intval($tag['priority']) : 0
                )
            );
        }
    }
}
