<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests\TimeZone;

use GpsLab\Bundle\DateBundle\TimeZone\Converter;
use GpsLab\Bundle\DateBundle\TimeZone\Keeper\KeeperInterface;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getDates()
    {
        $now = new \DateTime();

        $mock = $this->getMock(\DateTime::class);
        $mock
            ->expects($this->once())
            ->method('format')
            ->with(\DateTime::ISO8601)
            ->will($this->returnValue($now->format(\DateTime::ISO8601)))
        ;

        return [
            [$now, $now],
            [$now, $now->getTimestamp()],
            [$now, $now->format('r')],
            [$now, $mock],
        ];
    }

    /**
     * @dataProvider getDates
     *
     * @param \DateTime $expected
     * @param mixed $actual
     */
    public function testGetDateTime(\DateTime $expected, $actual)
    {
        $tz = new \DateTimeZone('Asia/Tokyo');

        /* @var $keeper \PHPUnit_Framework_MockObject_MockObject|KeeperInterface */
        $keeper = $this->getMock(KeeperInterface::class);
        $keeper
            ->expects($this->once())
            ->method('getUserTimeZone')
            ->will($this->returnValue($tz))
        ;

        $converter = new Converter($keeper);
        $actual = $converter->getDateTime($actual);

        $this->assertEquals($expected, $actual);
        $this->assertEquals($tz, $actual->getTimezone());
    }
}
