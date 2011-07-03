<?php

namespace Knp\Bundle\MediaExposerBundle\DependencyInjection;


/**
 * The media exposer DIC extension
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class KnpMediaExposerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('exposer.xml');
        $loader->load('templating.xml');

        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('knplabs_media_exposer.exposer_base_url', $config['base_url']);

        // when the base_url option is set to NULL, we register a listener to
        // compute it from the request
        if (null === $config['base_url']) {
            $loader->load('listener.xml');
        }
    }
}
