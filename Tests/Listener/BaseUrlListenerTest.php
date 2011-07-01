<?php

namespace Knplabs\Bundle\MediaExposerBundle\Tests\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Knplabs\Bundle\MediaExposerBundle\Listener\BaseUrlListener;

class BaseUrlListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelRequest()
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request
            ->expects($this->any())
            ->method('getBaseUrl')
            ->will($this->returnValue('/foo/bar'))
        ;
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

        $exposer
            ->expects($this->once())
            ->method('setBaseUrl')
            ->with($this->equalTo('http://the-host/foo/bar'))
        ;

        $event = new GetResponseEvent(
            $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface', array(), array(), '', false),
            $request,
            HttpKernelInterface::MASTER_REQUEST
        );

        $listener = new BaseUrlListener($exposer);
        $listener->onKernelRequest($event);
    }

    public function testOnKernelRequestWithFrontControllerInBaseUrl()
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request
            ->expects($this->any())
            ->method('getBaseUrl')
            ->will($this->returnValue('/foo/bar/app_dev.php'))
        ;
        $request
            ->expects($this->any())
            ->method('getScriptName')
            ->will($this->returnValue('app_dev.php'))
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

        $exposer
            ->expects($this->once())
            ->method('setBaseUrl')
            ->with($this->equalTo('http://the-host/foo/bar'))
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
