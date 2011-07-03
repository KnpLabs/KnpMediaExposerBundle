<?php

namespace Knp\Bundle\MediaExposerBundle\Tests\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Knp\Bundle\MediaExposerBundle\Listener\BaseUrlListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class BaseUrlListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelRequest()
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request
            ->expects($this->any())
            ->method('getScriptName')
            ->will($this->returnValue('app.php'))
        ;
        $request
            ->expects($this->any())
            ->method('getHttpHost')
            ->will($this->returnValue('the-host'))
        ;
        $request
            ->expects($this->any())
            ->method('getScheme')
            ->will($this->returnValue('http'))
        ;

        $exposer = $this->getMock('MediaExposer\Exposer');
        $exposer
            ->expects($this->once())
            ->method('setBaseUrl')
            ->with($this->equalTo('http://the-host'))
        ;

        $event = new GetResponseEvent(
            $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface', array(), array(), '', false),
            $request,
            HttpKernelInterface::MASTER_REQUEST
        );

        $listener = new BaseUrlListener($exposer);
        $listener->onKernelRequest($event);
    }
}
