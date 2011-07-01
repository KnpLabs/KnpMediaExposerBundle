<?php

namespace Knplabs\Bundle\MediaExposerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Knplabs\Bundle\MediaExposerBundle\DependencyInjection\Compiler\ExposerPass;

/**
 * The media exposer bundle
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class KnplabsMediaExposerBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExposerPass());
    }
}
