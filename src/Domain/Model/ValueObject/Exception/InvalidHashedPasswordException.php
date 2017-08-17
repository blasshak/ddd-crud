<?php

namespace Domain\Model\ValueObject\Exception;

/**
 * Class InvalidHashedPasswordException
 * @package Domain\Model\ValueObject\Exception
 */
class InvalidHashedPasswordException extends \Exception
{
    const MESSAGE = 'Invalid hashed password';
}
