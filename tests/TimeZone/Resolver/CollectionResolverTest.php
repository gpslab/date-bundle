<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests\TimeZone\Resolver;

use GpsLab\Bundle\DateBundle\TimeZone\Resolver\CollectionResolver;
use GpsLab\Bundle\DateBundle\TimeZone\Resolver\ResolverInterface;

class CollectionResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testCollection()
    {
        $collection = new CollectionResolver();

        /* @var $resolver1 \PHPUnit_Framework_MockObject_MockObject|ResolverInterface */
        $resolver1 = $this->getMock(ResolverInterface::class);
        $collection->addResolver($resolver1);

        /* @var $resolver2 \PHPUnit_Framework_MockObject_MockObject|ResolverInterface */
        $resolver2 = $this->getMock(ResolverInterface::class);
        $collection->addResolver($resolver2);

        $this->assertEquals([$resolver1, $resolver2], $collection->getResolvers());
    }
}
