<?php

namespace Infrastructure\Symfony\EventListener;

use CoreBundle\Infrastructure\Symfony\Security\Model\Auth;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JWTCreatedListener
 * @package Infrastructure\Symfony\EventListener
 */
class JWTCreatedListener
{
    /**
     * @access public
     * @param JWTCreatedEvent $event
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $expiration = new \DateTime('+1 day');

        /** @var Auth $user */
        $user               = $event->getUser();
        $payload            = $event->getData();
        $payload['uid']     = $user->id();
        $payload['email']   = $user->email();
        $payload['exp']     = $expiration->getTimestamp();
        $payload['roles']   = $user->getRoles();

        $event->setData($payload);
    }
}
