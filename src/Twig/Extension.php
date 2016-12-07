<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Twig;

use GpsLab\Bundle\DateBundle\Converter;
use GpsLab\Bundle\DateBundle\Formatter;
use GpsLab\Bundle\DateBundle\Comparator;

class Extension extends \Twig_Extension
{
    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @var Converter
     */
    protected $converter;

    /**
     * @var Comparator
     */
    protected $comparator;

    /**
     * @param Formatter $formatter
     * @param Converter $converter
     * @param Comparator $comparator
     */
    public function __construct(Formatter $formatter, Converter $converter, Comparator $comparator)
    {
        $this->formatter = $formatter;
        $this->converter = $converter;
        $this->comparator = $comparator;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('date', [$this, 'getDateFormat'], ['needs_environment' => true]),
            new \Twig_SimpleFilter('date_passed', [$this, 'getDatePassed']),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('compare_date_time', [$this, 'getCompareDateTime']),
            new \Twig_SimpleFunction('compare_date', [$this, 'getCompareDate']),
            new \Twig_SimpleFunction('compare_time', [$this, 'getCompareTime']),
            new \Twig_SimpleFunction('compare_week', [$this, 'getCompareWeek']),
            new \Twig_SimpleFunction('compare_month', [$this, 'getCompareMonth']),
            new \Twig_SimpleFunction('compare_year', [$this, 'getCompareYear']),
        ];
    }

    /**
     * @param \Twig_Environment $env
     * @param mixed $date
     * @param string|int|null $format
     *
     * @return string
     */
    public function getDateFormat(\Twig_Environment $env, $date, $format = null)
    {
        if ($format === null) {
            $formats = $env->getExtension('core')->getDateFormat();
            $format = $date instanceof \DateInterval ? $formats[1] : $formats[0];
        }

        // date time formatter not support date interval
        if ($date instanceof \DateInterval) {
            return $date->format($format);
        }

        return $this->formatter->format($this->convert($date), $format);
    }

    /**
     * @param mixed $date
     * @param string $time_format
     * @param string $month_format
     * @param string $year_format
     *
     * @return string
     */
    public function getDatePassed(
        $date,
        $time_format = Formatter::DEFAULT_PASSED_TIME_FORMAT,
        $month_format = Formatter::DEFAULT_PASSED_MONTH_FORMAT,
        $year_format = Formatter::DEFAULT_PASSED_YEAR_FORMAT
    ) {

        return $this->formatter->passed($this->convert($date), $time_format, $month_format, $year_format);
    }

    /**
     * @param mixed $x
     * @param string $operator
     * @param mixed $y
     *
     * @return bool
     */
    public function getCompareDateTime($x, $operator, $y)
    {
        return $this->comparator->compareDateTime($this->convert($x), $operator, $this->convert($y));
    }

    /**
     * @param mixed $x
     * @param string $operator
     * @param mixed $y
     *
     * @return bool
     */
    public function getCompareDate($x, $operator, $y)
    {
        return $this->comparator->compareDate($this->convert($x), $operator, $this->convert($y));
    }

    /**
     * @param mixed $x
     * @param string $operator
     * @param mixed $y
     *
     * @return bool
     */
    public function getCompareTime($x, $operator, $y)
    {
        return $this->comparator->compareTime($this->convert($x), $operator, $this->convert($y));
    }

    /**
     * @param mixed $x
     * @param string $operator
     * @param mixed $y
     *
     * @return bool
     */
    public function getCompareWeek($x, $operator, $y)
    {
        return $this->comparator->compareWeek($this->convert($x), $operator, $this->convert($y));
    }

    /**
     * @param mixed $x
     * @param string $operator
     * @param mixed $y
     *
     * @return bool
     */
    public function getCompareMonth($x, $operator, $y)
    {
        return $this->comparator->compareMonth($this->convert($x), $operator, $this->convert($y));
    }

    /**
     * @param mixed $x
     * @param string $operator
     * @param mixed $y
     *
     * @return bool
     */
    public function getCompareYear($x, $operator, $y)
    {
        return $this->comparator->compareYear($this->convert($x), $operator, $this->convert($y));
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    private function convert(\DateTime $date)
    {
        return $this->converter->getDateTime($date);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gpslab_date_extension';
    }
}
