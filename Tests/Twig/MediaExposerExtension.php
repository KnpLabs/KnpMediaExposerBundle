<?php

namespace Knp\Bundle\MediaExposerBundle\Tests\Twig;

use Knp\Bundle\MediaExposerBundle\Twig\MediaExposerExtension;

class MediaExposerHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSource()
    {
        $exposer = $this->getMock('MediaExposer\Exposer');
        $exposer
            ->expects($this->once())
            ->method('getSource')
            ->with($this->equalTo('THE_MEDIA'), $this->equalTo(array('foo' => 'bar')), $this->equalTo(true))
            ->will($this->returnValue('THE_SOURCE'))
        ;


        $extension = new MediaExposerExtension($exposer);

        $this->assertEquals(
            'THE_SOURCE',
            $extension->getSource('THE_MEDIA', array('foo' => 'bar'), true),
            'The ->getSource() method of the extension is a proxy to the exposer\'s one.'
        );
    }

    public function testGetPath()
    {
        $exposer = $this->getMock('MediaExposer\Exposer');
        $exposer
            ->expects($this->once())
            ->method('getPath')
            ->with($this->equalTo('THE_MEDIA'), $this->equalTo(array('foo' => 'bar')))
            ->will($this->returnValue('THE_PATH'))
        ;


        $extension = new MediaExposerExtension($exposer);

        $this->assertEquals(
            'THE_PATH',
            $extension->getSource('THE_MEDIA', array('foo' => 'bar')),
            'The ->getPath() method of the extension is a proxy to the exposer\'s one.'
        );
    }

    public function testGetName()
    {
        $exposer = $this->getMock('MediaExposer\Exposer');
        $extension = new MediaExposerExtension($exposer);

        $this->assertEquals('media_exposer', $extension->getName());
    }
}
