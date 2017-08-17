<?php

namespace Domain\Bus\Event\User;

use CoreBundle\Domain\Bus\Event\EventInterface;

/**
 * Class UserHasBeenRemovedEvent
 * @package Domain\Bus\Event\User
 */
class UserHasBeenRemovedEvent implements EventInterface
{
    const NAME = 'user_has_been_removed';

    /**
     * @access public
     * @return string
     */
    public function name() : string
    {
        return static::NAME;
    }
}
