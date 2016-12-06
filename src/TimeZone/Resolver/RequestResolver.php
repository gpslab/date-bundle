<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */
namespace GpsLab\Bundle\DateBundle\TimeZone\Resolver;

use Symfony\Component\HttpFoundation\RequestStack;

class RequestResolver implements ResolverInterface
{
    /**
     * @var RequestStack
     */
    protected $request_stack;

    /**
     * @var string
     */
    protected $time_zone_param = '';

    /**
     * @param RequestStack $request_stack
     * @param string $time_zone_param
     */
    public function __construct(RequestStack $request_stack, $time_zone_param)
    {
        $this->request_stack = $request_stack;
        $this->time_zone_param = $time_zone_param;
    }

    /**
     * @return \DateTimeZone|null
     */
    public function getUserTimeZone()
    {
        $time_zone = $this->request_stack->getMasterRequest()->cookies->get($this->time_zone_param);

        if (in_array($time_zone, \DateTimeZone::listIdentifiers())) {
            return new \DateTimeZone($time_zone);
        }

        return null;
    }
}
