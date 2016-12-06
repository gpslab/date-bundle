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
            ['12:30:00', 60, '12:30:00'],
            ['12:30:24', 60, '12:30:00'],
            ['12:30:54', 60, '12:31:00'],
            ['12:30:24', 600, '12:30:00'],
            ['12:32:54', 600, '12:30:00'],
            ['12:36:22', 600, '12:40:00'],
            ['12:31:24', 300, '12:30:00'],
            ['12:32:31', 300, '12:35:00'],
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
        $this->assertEquals(
            (new \DateTime($expected))->format(\DateTime::ISO8601),
            Util::roundDate(new \DateTime($date), $seconds)->format(\DateTime::ISO8601)
        );
    }
}
