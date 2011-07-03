<?php

namespace Knp\Bundle\MediaExposerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Knp\Bundle\MediaExposerBundle\DependencyInjection\Compiler\ExposerPass;

/**
 * The media exposer bundle
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class KnpMediaExposerBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExposerPass());
    }
}
