<?php

namespace Domain\Bus\Command\Exception;

/**
 * Class AuthenticationException
 * @package Domain\Bus\Command\Exception
 */
class AuthenticationException extends \Exception
{
    const MESSAGE = 'Invalid email or password';
}
