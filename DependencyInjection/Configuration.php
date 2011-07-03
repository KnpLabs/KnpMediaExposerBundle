<?php

namespace Knp\Bundle\MediaExposerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Configuration for the media exposer bundle
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('knplabs_media_exposer');
        $rootNode
            ->children()
                ->scalarNode('base_url')
            ->end()
        ;

        return $treeBuilder;
    }
}
