<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests\TimeZone\Resolver;

use GpsLab\Bundle\DateBundle\TimeZone\Resolver\RequestResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestStack|\PHPUnit_Framework_MockObject_MockObject
     */
    private $request_stack;

    /**
     * @var string
     */
    private $cookie_param_name = 'foo';

    /**
     * @var RequestResolver
     */
    private $resolver;

    protected function setUp()
    {
        $this->request_stack = $this
            ->getMockBuilder(RequestStack::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resolver = new RequestResolver($this->request_stack, true, $this->cookie_param_name);
    }

    public function testDisabled()
    {
        $this->request_stack
            ->expects($this->never())
            ->method('getMasterRequest');

        $this->resolver = new RequestResolver($this->request_stack, false, $this->cookie_param_name);

        $this->assertNull($this->resolver->getUserTimeZone());
    }

    /**
     * @return array
     */
    public function getTimeZones()
    {
        return [
            [
                null,
                'foo',
            ],
            [
                new \DateTimeZone('Europe/Moscow'),
                'Europe/Moscow',
            ],
            [
                new \DateTimeZone('Etc/GMT-6'),
                'Etc/GMT-6',
            ],
        ];
    }

    /**
     * @dataProvider getTimeZones
     *
     * @param \DateTimeZone|null $expected
     * @param string $actual
     */
    public function testGetUserTimeZone($expected, $actual)
    {
        $request = new Request([], [], [], [
            $this->cookie_param_name => $actual,
        ]);

        $this->request_stack
            ->expects($this->once())
            ->method('getMasterRequest')
            ->will($this->returnValue($request));

        $this->assertEquals($expected, $this->resolver->getUserTimeZone());
    }
}
