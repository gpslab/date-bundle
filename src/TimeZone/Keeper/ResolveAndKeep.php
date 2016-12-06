<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */
namespace GpsLab\Bundle\DateBundle\TimeZone\Keeper;

use GpsLab\Bundle\DateBundle\Converter;
use GpsLab\Bundle\DateBundle\TimeZone\Resolver\ChainResolver;

class ResolveAndKeep implements KeeperInterface
{
    /**
     * @var \DateTimeZone
     */
    protected $default_time_zone;

    /**
     * @var \DateTimeZone
     */
    protected $user_time_zone;

    /**
     * @var ChainResolver
     */
    protected $resolver;

    /**
     * @var Converter
     */
    protected $converter;

    /**
     * @param ChainResolver $resolver
     * @param Converter $converter
     * @param string $time_zone
     */
    public function __construct(ChainResolver $resolver, Converter $converter, $time_zone)
    {
        $this->resolver = $resolver;
        $this->converter = $converter;
        $this->default_time_zone = new \DateTimeZone($time_zone ?: date_default_timezone_get());
    }

    /**
     * @return \DateTimeZone
     */
    public function getDefaultTimeZone()
    {
        return clone $this->default_time_zone;
    }

    /**
     * @return \DateTimeZone
     */
    public function getUserTimeZone()
    {
        if (!($this->user_time_zone instanceof \DateTimeZone)) {
            // try resolve user TZ
            foreach ($this->resolver->getResolvers() as $resolver) {
                if ($tz = $resolver->getUserTimeZone()) {
                    $this->user_time_zone = $tz;
                    break;
                }
            }

            if (!($this->user_time_zone instanceof \DateTimeZone)) {
                $this->user_time_zone = clone $this->default_time_zone;
            }
        }

        return clone $this->user_time_zone;
    }

    /**
     * @param mixed $time
     *
     * @return \DateTime
     */
    public function getDefaultDateTime($time = 'now')
    {
        return $this->converter->getDateTime($time)->setTimezone($this->getDefaultTimeZone());
    }

    /**
     * @param mixed $time
     *
     * @return \DateTime
     */
    public function getUserDateTime($time = 'now')
    {
        return $this->converter->getDateTime($time)->setTimezone($this->getUserTimeZone());
    }

    /**
     * @param \DateTimeZone $tz
     *
     * @return self
     */
    public function setUserTimeZone(\DateTimeZone $tz)
    {
        $this->user_time_zone = $tz;

        return $this;
    }
}
