<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests;

use GpsLab\Bundle\DateBundle\Util;

class UtilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getMondays()
    {
        return [
            ['2015-07-06', '2015-07-06'],
            ['2015-07-07', '2015-07-06'],
            ['2015-07-08', '2015-07-06'],
            ['2015-07-09', '2015-07-06'],
            ['2015-07-10', '2015-07-06'],
            ['2015-07-11', '2015-07-06'],
            ['2015-07-12', '2015-07-06'],
            ['2017-01-01', '2016-12-26'],
            ['2016-01-02', '2015-12-28'],
        ];
    }

    /**
     * @dataProvider getMondays
     *
     * @param string $date
     * @param string $expected
     */
    public function testGetMondayThisWeek($date, $expected)
    {
        $this->assertEquals($expected, Util::getMondayThisWeek(new \DateTime($date))->format('Y-m-d'));
    }

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
    public function testRoundDate($date, $seconds, $expected)
    {
        $this->assertEquals($expected, Util::roundDate(new \DateTime($date), $seconds)->format('Y-m-d H:i:s'));
    }
}
