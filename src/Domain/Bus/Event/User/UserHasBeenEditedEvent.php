<?php

namespace Domain\Bus\Event\User;

use CoreBundle\Domain\Bus\Event\EventInterface;

/**
 * Class UserHasBeenEditedEvent
 * @package Domain\Bus\Event\User
 */
class UserHasBeenEditedEvent implements EventInterface
{
    const NAME = 'user_has_been_edited';

    /**
     * @access public
     * @return string
     */
    public function name() : string
    {
        return static::NAME;
    }
}
