<?php
/**
 * Pkvs package
 *
 * @package Pkvs
 * @author  Peter Gribanov <pgribanov@1tv.com>
 */

namespace GpsLab\Bundle\DateBundle\Tests;

use GpsLab\Bundle\DateBundle\RoundDate;

class RoundDateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getRoundDates()
    {
        return [
            ['2016-12-07 12:30:00', 60, '2016-12-07 12:30:00'],
            ['2016-12-07 12:30:24', 60, '2016-12-07 12:30:00'],
            ['2016-12-07 12:30:54', 60, '2016-12-07 12:31:00'],
            ['2016-12-07 12:30:24', 600, '2016-12-07 12:30:00'],
            ['2016-12-07 12:32:54', 600, '2016-12-07 12:30:00'],
            ['2016-12-07 12:36:22', 600, '2016-12-07 12:40:00'],
            ['2016-12-07 12:31:24', 300, '2016-12-07 12:30:00'],
            ['2016-12-07 12:32:31', 300, '2016-12-07 12:35:00'],
            ['2016-12-07 12:26:24', 3600, '2016-12-07 12:00:00'],
            ['2016-12-07 23:50:22', 3600, '2016-12-08 00:00:00'],
        ];
    }

    /**
     * @dataProvider getRoundDates
     *
     * @param string $date
     * @param int $seconds
     * @param string $expected
     */
    public function testRound($date, $seconds, $expected)
    {
        $this->assertEquals($expected, RoundDate::round(new \DateTime($date), $seconds)->format('Y-m-d H:i:s'));
    }

    /**
     * @return array
     */
    public function getFloorDates()
    {
        return [
            ['2016-12-07 12:30:00', 60, '2016-12-07 12:30:00'],
            ['2016-12-07 12:30:24', 60, '2016-12-07 12:30:00'],
            ['2016-12-07 12:30:54', 60, '2016-12-07 12:30:00'],
            ['2016-12-07 12:30:24', 600, '2016-12-07 12:30:00'],
            ['2016-12-07 12:32:54', 600, '2016-12-07 12:30:00'],
            ['2016-12-07 12:36:22', 600, '2016-12-07 12:30:00'],
            ['2016-12-07 12:31:24', 300, '2016-12-07 12:30:00'],
            ['2016-12-07 12:32:31', 300, '2016-12-07 12:30:00'],
            ['2016-12-07 12:26:24', 3600, '2016-12-07 12:00:00'],
            ['2016-12-07 23:50:22', 3600, '2016-12-07 23:00:00'],
        ];
    }

    /**
     * @dataProvider getFloorDates
     *
     * @param string $date
     * @param int $seconds
     * @param string $expected
     */
    public function testFloor($date, $seconds, $expected)
    {
        $this->assertEquals($expected, RoundDate::floor(new \DateTime($date), $seconds)->format('Y-m-d H:i:s'));
    }

    /**
     * @return array
     */
    public function getCeilDates()
    {
        return [
            ['2016-12-07 12:30:00', 60, '2016-12-07 12:30:00'],
            ['2016-12-07 12:30:24', 60, '2016-12-07 12:31:00'],
            ['2016-12-07 12:30:54', 60, '2016-12-07 12:31:00'],
            ['2016-12-07 12:30:24', 600, '2016-12-07 12:40:00'],
            ['2016-12-07 12:32:54', 600, '2016-12-07 12:40:00'],
            ['2016-12-07 12:36:22', 600, '2016-12-07 12:40:00'],
            ['2016-12-07 12:31:24', 300, '2016-12-07 12:35:00'],
            ['2016-12-07 12:33:31', 300, '2016-12-07 12:35:00'],
            ['2016-12-07 12:26:24', 3600, '2016-12-07 13:00:00'],
            ['2016-12-07 23:50:22', 3600, '2016-12-08 00:00:00'],
        ];
    }

    /**
     * @dataProvider getCeilDates
     *
     * @param string $date
     * @param int $seconds
     * @param string $expected
     */
    public function testCeil($date, $seconds, $expected)
    {
        $this->assertEquals($expected, RoundDate::ceil(new \DateTime($date), $seconds)->format('Y-m-d H:i:s'));
    }
}
