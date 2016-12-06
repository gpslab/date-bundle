<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\TimeZone\Resolver;

class ConsoleResolver implements ResolverInterface
{
    /**
     * @var \DateTimeZone
     */
    protected $default_time_zone;

    /**
     * @param string $time_zone
     */
    public function __construct($time_zone)
    {
        $this->default_time_zone = new \DateTimeZone($time_zone ?: date_default_timezone_get());
    }

    /**
     * @return \DateTimeZone|null
     */
    public function getUserTimeZone()
    {
        if (PHP_SAPI === 'cli') {
            return $this->default_time_zone;
        }

        return null;
    }
}
