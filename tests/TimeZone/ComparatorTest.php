<?php
/**
 * Pkvs package
 *
 * @package Pkvs
 * @author  Peter Gribanov <pgribanov@1tv.com>
 */

namespace GpsLab\Bundle\DateBundle\Tests\TimeZone;

use GpsLab\Bundle\DateBundle\TimeZone\Comparator;
use GpsLab\Bundle\DateBundle\TimeZone\Keeper\KeeperInterface;
use GpsLab\Bundle\DateBundle\Tests\ComparatorTest as DateComparatorTest;

class ComparatorTest extends DateComparatorTest
{
    /**
     * @var Comparator
     */
    protected $comparator;

    /**
     * @var KeeperInterface
     */
    protected $keeper;

    protected function setUp()
    {
        $this->keeper = $this->getMock(KeeperInterface::class);
        $this->keeper
            ->expects($this->atLeastOnce())
            ->method('getDefaultTimeZone')
            ->will($this->returnValue(new \DateTimeZone(date_default_timezone_get())));

        $this->comparator = new Comparator($this->keeper);
    }
}
