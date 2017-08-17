<?php

namespace Domain\Model\ValueObject;

use CoreBundle\Infrastructure\ValueObject\AbstractValueObject;
use Domain\Model\ValueObject\Exception\InvalidEmailException;

/**
 * Class Email
 * @package Domain\Model\ValueObject
 */
class Email extends AbstractValueObject
{
    /**
     * @access protected
     * @param $value
     * @throws InvalidEmailException
     */
    protected function __construct($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL) !== false) {
            throw new InvalidEmailException(InvalidEmailException::MESSAGE);
        }

        $this->setValue($value);
    }

}
