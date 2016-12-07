<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle;

use Symfony\Component\Translation\TranslatorInterface;

class Formatter
{
    /**
     * @var string
     */
    const DEFAULT_PASSED_TIME_FORMAT = 'H:i';
    const DEFAULT_PASSED_MONTH_FORMAT = 'd f \a\t H:i';
    const DEFAULT_PASSED_YEAR_FORMAT = 'd f Y \a\t H:i';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var array
     */
    protected $trans_format = [
        'f' => ['F', 'month.genitive.%s'],
        'D' => ['l', 'weekday.short.%s'],
        'l' => ['l', 'weekday.long.%s'],
        'F' => ['F', 'month.long.%s'],
        'M' => ['F', 'month.short.%s'],
    ];

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Format date.
     *
     * @see date()
     *
     * Additional:
     * f - Full name of the month, such as 'января' or 'марта' of January through December
     *
     * @param \DateTime $date
     * @param string $format
     *
     * @return string
     */
    public function format(\DateTime $date, $format)
    {
        $result = '';
        $escape = false;
        $length = strlen($format);

        for ($pos = 0; $pos < $length; ++$pos) {
            $char = mb_substr($format, $pos, 1, 'UTF-8');

            if ($char == '\\') {
                if ($escape) {
                    $result .= $char;
                }
                $escape = !$escape;
                continue;
            }

            if ($escape) { // escaped character
                $result .= $char;
            } elseif (isset($this->trans_format[$char])) {
                list($char, $trans) = $this->trans_format[$char];
                $result .= $this->trans(sprintf($trans, strtolower($date->format($char))));
            } else {
                $result .= $date->format($char);
            }

            $escape = false;
        }

        return $result;
    }

    /**
     * Passed date, such as 'X minutes ago', 'in X minutes', 'Today at H:i', 'Yesterday at H:i' or 'Tomorrow at H:i'.
     *
     * @param \DateTime $date
     * @param string $time_format
     * @param string $month_format
     * @param string $year_format
     *
     * @return string
     */
    public function passed(
        \DateTime $date,
        $time_format = self::DEFAULT_PASSED_TIME_FORMAT,
        $month_format = self::DEFAULT_PASSED_MONTH_FORMAT,
        $year_format = self::DEFAULT_PASSED_YEAR_FORMAT
    ) {
        $today = new \DateTime('now', $date->getTimezone());
        $yesterday = new \DateTime('-1 day', $date->getTimezone());
        $tomorrow = new \DateTime('+1 day', $date->getTimezone());
        $minutes_ago = round(($today->format('U') - $date->format('U')) / 60);
        $minutes_in = round(($date->format('U') - $today->format('U')) / 60);

        if ($minutes_ago > 0 && $minutes_ago < 60) {
            return $this->trans('passed.minutes_ago', ['%minutes%' => $minutes_ago]);
        } elseif ($minutes_in > 0 && $minutes_in < 60) {
            return $this->trans('passed.in_minutes', ['%minutes%' => $minutes_in]);
        } elseif ($today->format('ymd') == $date->format('ymd')) {
            return $this->trans('passed.today', ['%time%' => $this->format($date, $time_format)]);
        } elseif ($yesterday->format('ymd') == $date->format('ymd')) {
            return $this->trans('passed.yesterday', ['%time%' => $this->format($date, $time_format)]);
        } elseif ($tomorrow->format('ymd') == $date->format('ymd')) {
            return $this->trans('passed.tomorrow', ['%time%' => $this->format($date, $time_format)]);
        } elseif ($today->format('Y') == $date->format('Y')) {
            return $this->format($date, $month_format);
        } else {
            return $this->format($date, $year_format);
        }
    }

    /**
     * @param string $id
     * @param array $parameters
     *
     * @return string
     */
    private function trans($id, array $parameters = [])
    {
        return $this->translator->trans($id, $parameters, 'date');
    }
}
