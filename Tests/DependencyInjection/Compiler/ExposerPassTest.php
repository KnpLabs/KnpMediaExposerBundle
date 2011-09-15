<?php

namespace Knp\Bundle\MediaExposerBundle\Tests\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Knp\Bundle\MediaExposerBundle\DependencyInjection\Compiler\ExposerPass;

class ExposerPassTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $definition = new Definition();

        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $container
            ->expects($this->any())
            ->method('hasDefinition')
            ->with($this->equalTo('media_exposer'))
            ->will($this->returnValue(true))
        ;
        $container
            ->expects($this->any())
            ->method('getDefinition')
            ->with($this->equalTo('media_exposer'))
            ->will($this->returnValue($definition))
        ;
        $container
            ->expects($this->any())
            ->method('findTaggedServiceIds')
            ->with($this->equalTo('knp_media_exposer.resolver'))
            ->will($this->returnValue(array(
                'foo' => array(),
                'bar' => array(
                    array('priority' => 10)
                )
            )))
        ;

        $pass = new ExposerPass();
        $pass->process($container);

        $calls = $definition->getMethodCalls();

        $this->assertEquals(2, count($calls));

        $this->assertEquals('addResolver', $calls[0][0]);
        $this->assertEquals(2, count($calls[0][1]));
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Reference', $calls[0][1][0]);
        $this->assertAttributeEquals('foo', 'id', $calls[0][1][0]);
        $this->assertEquals(0, $calls[0][1][1]);

        $this->assertEquals('addResolver', $calls[1][0]);
        $this->assertEquals(2, count($calls[1][1]));
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Reference', $calls[1][1][0]);
        $this->assertAttributeEquals('bar', 'id', $calls[1][1][0]);
        $this->assertEquals(10, $calls[1][1][1]);
    }

    public function testProcessWithNoMediaExposerDefinition()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo('media_exposer'))
            ->will($this->returnValue(false))
        ;
        $container
            ->expects($this->never())
            ->method('getDefinition')
        ;
        $container
            ->expects($this->never())
            ->method('findTaggedServiceIds')
        ;

        $pass = new ExposerPass();
        $pass->process($container);
    }
}
