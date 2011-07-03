<?php

namespace Knp\Bundle\MediaExposerBundle\Tests\Helper;

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


        $helper = new MediaExposerHelper($exposer);

        $this->assertEquals(
            'THE_SOURCE',
            $helper->getSource('THE_MEDIA', array('foo' => 'bar'), true),
            'The ->getSource() method of the helper is a proxy to the exposer\'s one.'
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


        $helper = new MediaExposerHelper($exposer);

        $this->assertEquals(
            'THE_PATH',
            $helper->getSource('THE_MEDIA', array('foo' => 'bar')),
            'The ->getPath() method of the helper is a proxy to the exposer\'s one.'
        );
    }
}
