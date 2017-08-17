<?php

namespace Domain\Model\ValueObject;

use CoreBundle\Domain\Model\ValueObject\ValueObjectInterface;
use CoreBundle\Infrastructure\ValueObject\AbstractValueObject;
use Domain\Model\ValueObject\Exception\InvalidPasswordException;

/**
 * Class Password
 * @package Domain\Model\ValueObject
 */
class Password extends AbstractValueObject
{
    /**
     * @access protected
     * @param $value
     * @throws InvalidPasswordException
     */
    protected function __construct($value)
    {
        $pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';

        if (!preg_match($pattern, $value)) {
            throw new InvalidPasswordException(InvalidPasswordException::MESSAGE);
        }

        $this->setValue($value);
    }

    /**
     * @access public
     * @param ValueObjectInterface $repeatPassword
     * @throws InvalidPasswordException
     */
    public function checkPasswordAndRepeatPasswordAreEquals(ValueObjectInterface $repeatPassword)
    {
        if (!$this->equals($repeatPassword)) {
            throw new InvalidPasswordException(InvalidPasswordException::MESSAGE);
        }
    }
}
