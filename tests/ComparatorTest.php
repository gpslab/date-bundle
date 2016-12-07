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
    private $comparator;

    protected function setUp()
    {
        $this->comparator = new Comparator();
    }

    /**
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
}
