<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Event\Listener;

use GpsLab\Bundle\DateBundle\TimeZone\Keeper\KeeperInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;

class ResponseListener
{
    /**
     * @var KeeperInterface
     */
    private $keeper;

    /**
     * @var bool
     */
    private $cookie_used = true;

    /**
     * @var string
     */
    private $cookie_param_name = '';

    /**
     * @var string
     */
    private $cookie_param_offset = '';

    /**
     * @param KeeperInterface $tz_keeper
     * @param bool $cookie_used
     * @param string $cookie_param_name
     * @param string $cookie_param_offset
     */
    public function __construct(KeeperInterface $tz_keeper, $cookie_used, $cookie_param_name, $cookie_param_offset)
    {
        $this->keeper = $tz_keeper;
        $this->cookie_used = $cookie_used;
        $this->cookie_param_name = $cookie_param_name;
        $this->cookie_param_offset = $cookie_param_offset;
    }

    /**
     * Save user time zone.
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponseSaveUserTimeZone(FilterResponseEvent $event)
    {
        if ($this->cookie_used && $event->isMasterRequest()) {
            $cookies = $event->getRequest()->cookies;
            $headers = $event->getResponse()->headers;
            $tz = $this->keeper->getUserTimeZone();
            $offset = $tz->getOffset($this->keeper->getDefaultDateTime());

            if (
                $cookies->get($this->cookie_param_name) != $tz->getName() ||
                $cookies->get($this->cookie_param_offset) != $offset
            ) {
                $headers->setCookie($this->getCookie($this->cookie_param_name, $tz->getName()));
                $headers->setCookie($this->getCookie($this->cookie_param_offset, $offset));
            }
        }
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return Cookie
     */
    protected function getCookie($name, $value)
    {
        return new Cookie($name, $value, strtotime('+1 year'), '/', null, false, false);
    }
}
