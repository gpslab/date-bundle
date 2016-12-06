<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\TimeZone;

use GpsLab\Bundle\DateBundle\Converter as DateConverter;
use GpsLab\Bundle\DateBundle\TimeZone\Keeper\KeeperInterface;

class Converter extends DateConverter
{
    /**
     * @var KeeperInterface
     */
    private $keeper;

    /**
     * @param KeeperInterface $keeper
     */
    public function __construct(KeeperInterface $keeper)
    {
        $this->keeper = $keeper;
    }

    /**
     * @param mixed $date
     *
     * @return \DateTime
     */
    public function getDateTime($date)
    {
        return parent::getDateTime($date)->setTimezone($this->keeper->getUserTimeZone());
    }
}
