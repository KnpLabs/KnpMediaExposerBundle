<?php

namespace Knp\Bundle\MediaExposerBundle\Listener;

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
     */
    private function computeBaseUrl(Request $request)
    {
        $baseUrl = $request->getBaseUrl();
        $script  = $request->getScriptName();

        // remove script name if it is in the base path
        if ($script = substr($baseUrl, 1, 1 + strlen($script))) {
            $baseUrl = substr($baseUrl, 1, strlen($baseUrl) - strlen($script) - 1);
        }

        return $request->getScheme() . '://' . $request->getHttpHost() . $baseUrl;
    }
}
