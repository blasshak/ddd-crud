<?php

namespace Domain\Model\ValueObject;

use CoreBundle\Infrastructure\ValueObject\AbstractValueObject;
use Domain\Model\ValueObject\Exception\InvalidHashedPasswordException;

/**
 * Class HashedPassword
 * @package Domain\Model\ValueObject
 */
class HashedPassword extends AbstractValueObject
{
    /**
     * @access protected
     * @param $value
     * @throws InvalidHashedPasswordException
     */
    protected function __construct($value)
    {
        $this->setValue($value);
    }
}
