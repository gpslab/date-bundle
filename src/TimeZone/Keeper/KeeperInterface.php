<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */
namespace GpsLab\Bundle\DateBundle\TimeZone\Keeper;

interface KeeperInterface
{
    /**
     * @return \DateTimeZone
     */
    public function getDefaultTimeZone();

    /**
     * @return \DateTimeZone
     */
    public function getUserTimeZone();

    /**
     * @param mixed $time
     *
     * @return \DateTime
     */
    public function getDefaultDateTime($time = 'now');

    /**
     * @param mixed $time
     *
     * @return \DateTime
     */
    public function getUserDateTime($time = 'now');

    /**
     * @param \DateTimeZone $tz
     *
     * @return self
     */
    public function setUserTimeZone(\DateTimeZone $tz);
}
