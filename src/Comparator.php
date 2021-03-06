<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle;

use GpsLab\Bundle\DateBundle\Exception\InvalidCompareOperatorException;

class Comparator
{
    const EQ = '=';
    const NEQ = '!=';
    const LT = '<';
    const LTE = '<=';
    const GT = '>';
    const GTE = '>=';

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
        switch ($operator) {
            case self::EQ:
            case '==':
                return $x == $y;
            case self::NEQ:
            case '<>':
                return $x != $y;
            case self::GT:
                return $x > $y;
            case self::GTE:
                return $x >= $y;
            case self::LT:
                return $x < $y;
            case self::LTE:
                return $x <= $y;
            default:
                throw InvalidCompareOperatorException::create($operator);
        }
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
        return $this->compareDateTime($this->resetTime($x), $operator, $this->resetTime($y));
    }

    /**
     * Compare only time.
     *
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareTime(\DateTime $x, $operator, \DateTime $y)
    {
        return $this->compareDateTime($this->resetDate($x), $operator, $this->resetDate($y));
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
        return $this->compareDateTime($this->resetWeek($x), $operator, $this->resetWeek($y));
    }

    /**
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareMonth(\DateTime $x, $operator, \DateTime $y)
    {
        return $this->compareDateTime($this->resetMonth($x), $operator, $this->resetMonth($y));
    }

    /**
     * @param \DateTime $x
     * @param string $operator
     * @param \DateTime $y
     *
     * @return bool
     */
    public function compareYear(\DateTime $x, $operator, \DateTime $y)
    {
        return $this->compareDateTime($this->resetYear($x), $operator, $this->resetYear($y));
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    protected function resetTime(\DateTime $date)
    {
        $date = clone $date;
        $date->setTime(0, 0, 0);

        return $date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    protected function resetDate(\DateTime $date)
    {
        $date = clone $date;
        $date->setDate(1, 1, 1);

        return $date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    protected function resetWeek(\DateTime $date)
    {
        $date = clone $date;
        $date->modify('Monday this week')->setTime(0, 0, 0);

        return $date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    protected function resetMonth(\DateTime $date)
    {
        $date = clone $date;
        $date->modify('first day of this month')->setTime(0, 0, 0);

        return $date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    protected function resetYear(\DateTime $date)
    {
        $date = clone $date;
        $date->modify('first day of this year')->setTime(0, 0, 0);

        return $date;
    }
}
