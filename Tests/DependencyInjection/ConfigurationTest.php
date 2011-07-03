<?php

namespace Knp\Bundle\MediaExposerBundle\Tests\DependencyInjection;

use Knp\Bundle\MediaExposerBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataForResultConfig
     */
    public function testResultConfig(array $configs, array $expected)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $this->assertEquals($expected, $processor->processConfiguration($configuration, $configs));
    }

    public function dataForResultConfig()
    {
        return array(
            array(
                array(
                    array(
                        'base_url'  => 'http://foo.bar'
                    ),
                    array(
                        'base_url'  => 'http://the-base.url'
                    ),
                    array()
                ),
                array(
                    'base_url'  => 'http://the-base.url'
                )
            ),
            array(
                array(
                    array(
                        'base_url'  => 'http://foo.bar'
                    ),
                    array(
                        'base_url'  => null
                    )
                ),
                array(
                    'base_url'  => null
                )
            )
        );
    }
}
