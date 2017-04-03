<?php
/**
 * Pkvs package
 *
 * @package Pkvs
 * @author  Peter Gribanov <pgribanov@1tv.com>
 */

namespace GpsLab\Bundle\DateBundle;

class RoundDate
{
    /**
     * @param \DateTime $date
     * @param int $seconds
     *
     * @return \DateTime
     */
    public static function round(\DateTime $date, $seconds)
    {
        return self::setTimestamp($date, round($date->getTimestamp() / $seconds) * $seconds);
    }

    /**
     * @param \DateTime $date
     * @param int $seconds
     *
     * @return \DateTime
     */
    public static function floor(\DateTime $date, $seconds)
    {

        return self::setTimestamp($date, floor($date->getTimestamp() / $seconds) * $seconds);
    }

    /**
     * @param \DateTime $date
     * @param int $seconds
     *
     * @return \DateTime
     */
    public static function ceil(\DateTime $date, $seconds)
    {
        return self::setTimestamp($date, ceil($date->getTimestamp() / $seconds) * $seconds);
    }

    /**
     * @param \DateTime $date
     * @param int $uts
     *
     * @return \DateTime
     */
    private static function setTimestamp(\DateTime $date, $uts)
    {
        $date = clone $date;

        return $date->setTimestamp($uts);
    }
}
