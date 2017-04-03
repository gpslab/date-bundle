<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle;

class Util
{
    /**
     * Bugfix for get monday of this week.
     *
     * @see https://bugs.php.net/bug.php?id=63740
     *
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    public static function getMondayThisWeek(\DateTime $date)
    {
        $monday = clone $date;
        $number = $monday->format('N');
        if ($number != 1) {
            $monday->modify('-'.($number - 1).' day');
        }

        return $monday;
    }

    /**
     * @deprecated it will be removed in later.
     *
     * @see RoundDate::round()
     * @codeCoverageIgnore
     *
     * @param \DateTime $date
     * @param int $seconds
     *
     * @return \DateTime
     */
    public static function roundDate(\DateTime $date, $seconds)
    {
        return RoundDate::round($date, $seconds);
    }
}
