<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests;

use GpsLab\Bundle\DateBundle\Converter;

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
        $converter = new Converter();

        $this->assertEquals($expected, $converter->getDateTime($actual));
    }
}
