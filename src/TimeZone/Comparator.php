<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\TimeZone;

use GpsLab\Bundle\DateBundle\Comparator as DateComparator;
use GpsLab\Bundle\DateBundle\TimeZone\Keeper\KeeperInterface;

class Comparator extends DateComparator
{
    /**
     * @var KeeperInterface
     */
    protected $keeper;

    /**
     * @param KeeperInterface $keeper
     */
    public function __construct(KeeperInterface $keeper)
    {
        $this->keeper = $keeper;
    }

    /**
     * Synonym for Comparator::compareDateTime().
     *
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compare(\DateTime $x, $operator, \DateTime $y)
    {
        return $this->compareDateTime($x, $operator, $y);
    }

    /**
     * Compare date and time.
     *
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareDateTime(\DateTime $x, $operator, \DateTime $y)
    {
        return parent::compareDateTime($this->resetTimezone($x), $operator, $this->resetTimezone($y));
    }

    /**
     * Compare only date. Not compare time.
     *
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareDate(\DateTime $x, $operator, \DateTime $y)
    {
        return parent::compareDate($this->resetTimezone($x), $operator, $this->resetTimezone($y));
    }

    /**
     * Compare only time. Not compare date.
     *
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareTime(\DateTime $x, $operator, \DateTime $y)
    {
        return parent::compareTime($this->resetTimezone($x), $operator, $this->resetTimezone($y));
    }

    /**
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareWeek(\DateTime $x, $operator, \DateTime $y)
    {
        return parent::compareWeek($this->resetTimezone($x), $operator, $this->resetTimezone($y));
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    protected function resetTimezone(\DateTime $date)
    {
        $date = clone $date;
        $date->setTimezone($this->keeper->getDefaultTimeZone());

        return $date;
    }
}
