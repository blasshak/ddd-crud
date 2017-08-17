<?php

namespace Domain\Bus\Event\User;

use CoreBundle\Domain\Bus\Event\EventInterface;

/**
 * Class UserHasBeenSignedUpEvent
 * @package Domain\Bus\Event\User
 */
class UserHasBeenSignedUpEvent implements EventInterface
{
    const NAME = 'user_has_been_signed_up';

    /**
     * @access public
     * @return string
     */
    public function name() : string
    {
        return static::NAME;
    }
}
