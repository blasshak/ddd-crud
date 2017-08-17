<?php

namespace Domain\Specification\Exception;

/**
 * Class PermissionsException
 * @package Domain\Specification\Exception
 */
class PermissionsException extends \Exception
{
    const MESSAGE = 'You do not have permissions';
}
