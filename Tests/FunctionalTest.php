<?php

namespace Knp\Bundle\MediaExposerBundle\Tests;

use Symfony\Component\HttpKernel\Util\Filesystem;

require_once __DIR__.'/fixtures/app/TestKernel.php';

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    private static $filesystem;
    private static $kernel;

    public static function setUpBeforeClass()
    {
        static::$kernel = new TestKernel('prod', false);

        $filesystem = new Filesystem();
        $filesystem->mkdir(static::$kernel->getCacheDir());
    }

    public function setUp()
    {
        static::$kernel->boot();
    }

    public function tearDown()
    {
        static::$kernel->shutdown();
    }

    public static function tearDownAfterClass()
    {
        $filesystem = new Filesystem();
        $filesystem->remove(static::$kernel->getCacheDir());
    }

    public function testResolversAreAddedToTheExposer()
    {
        $container = static::$kernel->getContainer();

        $foo = $container->get('foo');
        $bar = $container->get('bar');
        $baz = $container->get('baz');

        $exposer = $container->get('media_exposer');

        $resolvers = iterator_to_array($exposer->getSortedResolvers(), false);

        $this->assertEquals(array($foo, $bar, $baz), $resolvers);
    }

    public function testTwigExtensionIsRegistered()
    {
        $twig = static::$kernel->getContainer()->get('twig');

        $this->assertTrue($twig->hasExtension('media_exposer'));
        $this->assertInstanceOf('Knp\Bundle\MediaExposerBundle\Twig\MediaExposerExtension', $twig->getExtension('media_exposer'));
    }

    public function testPhpTemplatingHelperIsRegistered()
    {
        $engine = static::$kernel->getContainer()->get('templating.engine.php');

        $this->assertTrue(isset($engine['media_exposer']));
        $this->assertInstanceOf('Knp\Bundle\MediaExposerBundle\Helper\MediaExposerHelper', $engine['media_exposer']);
    }
}
