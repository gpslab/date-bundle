<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests;

use GpsLab\Bundle\DateBundle\Comparator;

class ComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Comparator
     */
    protected $comparator;

    protected function setUp()
    {
        $this->comparator = new Comparator();
    }

    /**
     * @return array
     */
    public function getMethod()
    {
        return [
            ['compare'],
            ['compareDateTime'],
            ['compareDate'],
            ['compareTime'],
            ['compareWeek'],
            ['compareMonth'],
            ['compareYear'],
        ];
    }

    /**
     * @dataProvider getMethod
     * @expectedException \GpsLab\Bundle\DateBundle\Exception\InvalidCompareOperatorException
     *
     * @param string $method
     */
    public function testInvalidOperator($method)
    {
        call_user_func([$this->comparator, $method], new \DateTime(), '||', new \DateTime());
    }

    /**
     * @return array
     */
    public function getCompareDateTime()
    {
        return [
            ['2016-12-07', '=', '2016-12-07', true],
            ['2016-12-07 12:30:40', '==', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '!=', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<>', '2016-12-07 12:30:40', false],
            ['2016-12-08 12:30:40', '>', '2016-12-07 12:30:40', true],
            ['2016-12-08 12:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<', '2016-12-08 12:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-08 12:30:40', true],
        ];
    }

    /**
     * @dataProvider getCompareDateTime
     *
     * @param string $x
     * @param string $operator
     * @param string $y
     * @param bool $expected
     */
    public function testCompareDateTime($x, $operator, $y, $expected)
    {
        $x = new \DateTime($x);
        $y = new \DateTime($y);

        $this->assertEquals($expected, $this->comparator->compare($x, $operator, $y));
        $this->assertEquals($expected, $this->comparator->compareDateTime($x, $operator, $y));
    }

    /**
     * @return array
     */
    public function getCompareDate()
    {
        return [
            ['2016-12-07', '=', '2016-12-07', true],
            ['2016-12-07 12:30:40', '==', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '!=', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<>', '2016-12-07 12:30:40', false],
            ['2016-12-08 11:30:40', '>', '2016-12-07 12:30:40', true],
            ['2016-12-08 11:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<', '2016-12-08 11:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-08 11:30:40', true],
        ];
    }

    /**
     * @dataProvider getCompareDate
     *
     * @param string $x
     * @param string $operator
     * @param string $y
     * @param bool $expected
     */
    public function testCompareDate($x, $operator, $y, $expected)
    {
        $x = new \DateTime($x);
        $y = new \DateTime($y);

        $this->assertEquals($expected, $this->comparator->compareDate($x, $operator, $y));
    }

    /**
     * @return array
     */
    public function getCompareTime()
    {
        return [
            ['2016-12-07', '=', '2016-12-07', true],
            ['2016-12-07 12:30:40', '==', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '!=', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<>', '2016-12-07 12:30:40', false],
            ['2016-12-07 13:30:40', '>', '2016-12-07 12:30:40', true],
            ['2016-12-07 13:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<', '2016-12-07 13:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-07 13:30:40', true],
        ];
    }

    /**
     * @dataProvider getCompareTime
     *
     * @param string $x
     * @param string $operator
     * @param string $y
     * @param bool $expected
     */
    public function testCompareTime($x, $operator, $y, $expected)
    {
        $x = new \DateTime($x);
        $y = new \DateTime($y);

        $this->assertEquals($expected, $this->comparator->compareTime($x, $operator, $y));
    }

    /**
     * @return array
     */
    public function getCompareWeek()
    {
        return [
            ['2016-12-05', '=', '2016-12-05', true],
            ['2016-12-05 12:30:40', '==', '2016-12-05 12:30:40', true],
            ['2016-12-05 12:30:40', '>=', '2016-12-05 12:30:40', true],
            ['2016-12-05 12:30:40', '<=', '2016-12-05 12:30:40', true],
            ['2016-12-05 12:30:40', '>', '2016-12-05 12:30:40', false],
            ['2016-12-05 12:30:40', '<', '2016-12-05 12:30:40', false],
            ['2016-12-05 12:30:40', '!=', '2016-12-05 12:30:40', false],
            ['2016-12-05 12:30:40', '<>', '2016-12-05 12:30:40', false],
            ['2016-12-14 11:30:40', '>', '2016-12-05 12:30:40', true],
            ['2016-12-14 11:30:40', '>=', '2016-12-05 12:30:40', true],
            ['2016-12-05 12:30:40', '<', '2016-12-14 11:30:40', true],
            ['2016-12-05 12:30:40', '<=', '2016-12-14 11:30:40', true],
        ];
    }

    /**
     * @dataProvider getCompareWeek
     *
     * @param string $x
     * @param string $operator
     * @param string $y
     * @param bool $expected
     */
    public function testCompareWeek($x, $operator, $y, $expected)
    {
        $x = new \DateTime($x);
        $y = new \DateTime($y);

        $this->assertEquals($expected, $this->comparator->compareWeek($x, $operator, $y));
    }

    /**
     * @return array
     */
    public function getCompareMonth()
    {
        return [
            ['2016-12-07', '=', '2016-12-07', true],
            ['2016-12-07 12:30:40', '==', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '!=', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<>', '2016-12-07 12:30:40', false],
            ['2016-12-07 11:30:40', '>', '2016-11-07 12:30:40', true],
            ['2016-12-07 11:30:40', '>=', '2016-11-07 12:30:40', true],
            ['2016-11-07 12:30:40', '<', '2016-12-07 11:30:40', true],
            ['2016-11-07 12:30:40', '<=', '2016-12-07 11:30:40', true],
        ];
    }

    /**
     * @dataProvider getCompareMonth
     *
     * @param string $x
     * @param string $operator
     * @param string $y
     * @param bool $expected
     */
    public function testCompareMonth($x, $operator, $y, $expected)
    {
        $x = new \DateTime($x);
        $y = new \DateTime($y);

        $this->assertEquals($expected, $this->comparator->compareMonth($x, $operator, $y));
    }

    /**
     * @return array
     */
    public function getCompareYear()
    {
        return [
            ['2016-12-07', '=', '2016-12-07', true],
            ['2016-12-07 12:30:40', '==', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '>', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '!=', '2016-12-07 12:30:40', false],
            ['2016-12-07 12:30:40', '<>', '2016-12-07 12:30:40', false],
            ['2017-11-06 11:30:40', '>', '2016-12-07 12:30:40', true],
            ['2017-11-06 11:30:40', '>=', '2016-12-07 12:30:40', true],
            ['2016-12-07 12:30:40', '<', '2017-11-06 11:30:40', true],
            ['2016-12-07 12:30:40', '<=', '2017-11-06 11:30:40', true],
        ];
    }

    /**
     * @dataProvider getCompareYear
     *
     * @param string $x
     * @param string $operator
     * @param string $y
     * @param bool $expected
     */
    public function testCompareYear($x, $operator, $y, $expected)
    {
        $x = new \DateTime($x);
        $y = new \DateTime($y);

        $this->assertEquals($expected, $this->comparator->compare($x, $operator, $y));
        $this->assertEquals($expected, $this->comparator->compareYear($x, $operator, $y));
    }
}
