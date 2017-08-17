<?php

namespace Domain\Model\ValueObject;

use Domain\Model\ValueObject\Exception\InvalidPasswordException;

/**
 * Class NewPassword
 * @package Domain\Model\ValueObject
 */
class NewPassword extends Password
{
    /**
     * @access protected
     * @param $value
     * @throws InvalidPasswordException
     */
    protected function __construct($value)
    {
        if (!empty($value)) {
            parent::__construct($value);
        } else {
            $this->setValue($value);
        }
    }
}
