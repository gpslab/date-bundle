<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle;

class Converter
{
    /**
     * @param mixed $date
     *
     * @return \DateTime
     */
    public function getDateTime($date)
    {
        if ($date instanceof \DateTime) {
            // not need convert
        } elseif ($date instanceof \DateTimeInterface) {
            $date = new \DateTime($date->format(\DateTime::ISO8601));
        } elseif (is_numeric($date)) { // is UTS
            $date = (new \DateTime())->setTimestamp($date);
        } else {
            $date = new \DateTime($date);
        }

        return $date;
    }
}
