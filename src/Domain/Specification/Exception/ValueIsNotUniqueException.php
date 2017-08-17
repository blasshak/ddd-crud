<?php

namespace Domain\Specification\Exception;

/**
 * Class ValueIsNotUniqueException
 * @package Domain\Specification\Exception
 */
class ValueIsNotUniqueException extends \Exception
{
    /**
     * @access public
     * @param string $value
     * @return ValueIsNotUniqueException
     */
    public static function fromValue($value) : ValueIsNotUniqueException
    {
        return new static(sprintf('%s is already registered', $value));
    }
}
