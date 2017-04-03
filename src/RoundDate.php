<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
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
