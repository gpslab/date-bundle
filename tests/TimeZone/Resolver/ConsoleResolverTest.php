<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests\TimeZone\Resolver;

use GpsLab\Bundle\DateBundle\TimeZone\Resolver\ConsoleResolver;

class ConsoleResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTimeZones()
    {
        return [
            [null, new \DateTimeZone(date_default_timezone_get())],
            ['Asia/Tokyo', new \DateTimeZone('Asia/Tokyo')],
        ];
    }

    /**
     * @dataProvider getTimeZones
     *
     * @param mixed $actual
     * @param \DateTimeZone $expected
     */
    public function testGetUserTimeZone($actual, \DateTimeZone $expected)
    {
        $resolver = new ConsoleResolver($actual);

        $this->assertEquals($expected, $resolver->getUserTimeZone());
    }
}
