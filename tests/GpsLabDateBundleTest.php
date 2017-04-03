<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests;

use GpsLab\Bundle\DateBundle\DependencyInjection\Compiler\TimeZoneResolverPass;
use GpsLab\Bundle\DateBundle\DependencyInjection\GpsLabDateExtension;
use GpsLab\Bundle\DateBundle\GpsLabDateBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GpsLabDateBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        /* @var $container \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder */
        $container = $this->getMock(ContainerBuilder::class);
        $container
            ->expects($this->once())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(TimeZoneResolverPass::class))
        ;

        $bundle = new GpsLabDateBundle();
        $bundle->build($container);
    }

    public function testGetContainerExtension()
    {
        $bundle = new GpsLabDateBundle();
        $extension = $bundle->getContainerExtension();

        $this->assertInstanceOf(
            GpsLabDateExtension::class,
            $extension
        );
    }
}
