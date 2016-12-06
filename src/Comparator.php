<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle;

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
                throw new \InvalidArgumentException(sprintf('Operator "%s" is not supported.', $operator));
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
        return Util::getMondayThisWeek($date)->setTime(0, 0, 0);
    }
}
