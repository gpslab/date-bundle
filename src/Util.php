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
     * Get monday of this week
     *
     * Bugfix:
     * @link https://bugs.php.net/bug.php?id=63740
     *
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    public static function getMondayThisWeek(\DateTime $date)
    {
        $monday = clone $date;

        if ($monday->format('N') != 1) {
            $monday->modify('Monday this week');

            if ($date->format('Y W') != $monday->format('Y W')) {
                $monday->modify('-7 day');
            }
        }

        return $monday;
    }

    /**
     * @param \DateTime $date
     * @param int $seconds
     *
     * @return \DateTime
     */
    public static function roundDate(\DateTime $date, $seconds)
    {
        $date = clone $date;

        return $date->setTimestamp(round($date->getTimestamp() / $seconds) * $seconds);
    }
}
