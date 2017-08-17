<?php

namespace Domain\Bus\Command\Exception;

/**
 * Class InvalidRequestException
 * @package Domain\Bus\Command\Exception
 */
class InvalidRequestException extends \Exception
{
    const MESSAGE = 'Invalid request';
}
