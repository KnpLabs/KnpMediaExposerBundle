<?php

namespace Knp\Bundle\MediaExposerBundle\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use MediaExposer\Exposer;

/**
 * Listener responsible of injecting the base url computed from the request
 * to the media exposer.
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class BaseUrlListener
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
     * Listens to the "kernel.request" event in order to define the base url
     *
     * @param  GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $this->exposer->setBaseUrl($this->computeBaseUrl($request));
    }

    /**
     * Computes the base url from the given request
     *
     * @param  Request $request
     *
     * @return string
     *
     * @todo improve this method
     */
    private function computeBaseUrl(Request $request)
    {
        return $request->getScheme() . '://' . $request->getHttpHost();
    }
}
