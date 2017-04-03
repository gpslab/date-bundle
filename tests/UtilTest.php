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
}
