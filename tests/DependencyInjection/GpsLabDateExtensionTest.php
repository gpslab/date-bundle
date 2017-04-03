<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests\DependencyInjection;

use GpsLab\Bundle\DateBundle\DependencyInjection\GpsLabDateExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GpsLabDateExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        /* @var $container \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder */
        $container = $this->getMock(ContainerBuilder::class);
        $container
            ->expects($this->at(0))
            ->method('setParameter')
            ->with('date.time_zone', date_default_timezone_get())
        ;
        $container
            ->expects($this->at(1))
            ->method('setParameter')
            ->with('date.time_zone.cookie.used', true)
        ;
        $container
            ->expects($this->at(2))
            ->method('setParameter')
            ->with('date.time_zone.cookie.param.name', '_time_zone_name')
        ;
        $container
            ->expects($this->at(3))
            ->method('setParameter')
            ->with('date.time_zone.cookie.param.offset', '_time_zone_offset')
        ;

        $extension = new GpsLabDateExtension();
        $extension->load([], $container);
    }

    public function testGetAlias()
    {
        $extension = new GpsLabDateExtension();
        $this->assertEquals('gpslab_date', $extension->getAlias());
    }
}
