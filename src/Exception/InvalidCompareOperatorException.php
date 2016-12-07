<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Exception;

class InvalidCompareOperatorException extends \InvalidArgumentException
{
    /**
     * @param string $operator
     *
     * @return InvalidCompareOperatorException
     */
    public static function create($operator)
    {
        return new self(sprintf('Operator "%s" is not supported.', $operator));
    }
}
