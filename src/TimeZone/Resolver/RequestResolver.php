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
    private $request_stack;

    /**
     * @var bool
     */
    private $cookie_used = true;

    /**
     * @var string
     */
    private $cookie_param_name = '';

    /**
     * @param RequestStack $request_stack
     * @param bool $cookie_used
     * @param string $cookie_param_name
     */
    public function __construct(RequestStack $request_stack, $cookie_used, $cookie_param_name)
    {
        $this->request_stack = $request_stack;
        $this->cookie_used = $cookie_used;
        $this->cookie_param_name = $cookie_param_name;
    }

    /**
     * @return \DateTimeZone|null
     */
    public function getUserTimeZone()
    {
        if (!$this->cookie_used) {
            return null;
        }

        $time_zone = $this->request_stack->getMasterRequest()->cookies->get($this->cookie_param_name);

        if (in_array($time_zone, \DateTimeZone::listIdentifiers())) {
            return new \DateTimeZone($time_zone);
        }

        return null;
    }
}
