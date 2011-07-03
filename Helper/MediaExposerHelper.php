<?php

namespace Knp\Bundle\MediaExposerBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use MediaExposer\Exposer;

/**
 * The media helper for the PHP templating engine
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class MediaExposerHelper extends Helper
{
    private $exposer;

    /**
     * Constructor
     *
     * @param  Exposer $exposer
     */
    public function __construct(Exposer $exposer)
    {
        $this->exposer = $exposer;
    }

    /**
     * Proxy for the method of the exposer
     *
     * @see Exposer::getSource()
     */
    public function getSource($media, array $options = array(), $forceAbsolute = false)
    {
        return $this->exposer->getSource($media, $options, $forceAbsolute);
    }

    /**
     * Proxy for the method of the exposer
     *
     * @see Exposer::getSource()
     */
    public function getPath($media, array $options = array())
    {
        return $this->exposer->getPath($media, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'media_exposer';
    }
}
