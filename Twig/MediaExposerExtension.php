<?php

namespace Knp\Bundle\MediaExposerBundle\Twig;

use MediaExposer\Exposer;
use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;

/**
 * The media exposer extension for twig
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class MediaExposerExtension extends Twig_Extension
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
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'media_source'  => new Twig_Filter_Method($this, 'getSource'),
            'media_path'    => new Twig_Filter_Method($this, 'getPath')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'media_source'  => new Twig_Function_Method($this, 'getSource'),
            'media_path'    => new Twig_Function_Method($this, 'getPath')
        );
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
