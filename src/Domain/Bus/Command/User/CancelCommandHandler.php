<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Event\EventProviderInterface;
use Domain\Bus\Event\User\UserHasBeenRemovedEvent;
use Domain\Model\ValueObject\Email;
use Domain\Repository\UserRepositoryInterface;

/**
 * Class CancelCommandHandler
 * @package Domain\Bus\Command\User
 */
class CancelCommandHandler implements CommandHandlerInterface
{
    /**
     * @access private
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @access private
     * @var EventProviderInterface
     */
    private $eventProvider;

    /**
     * @access public
     * @param UserRepositoryInterface $userRepository
     * @param EventProviderInterface $eventProvider
     */
    public function __construct(UserRepositoryInterface $userRepository, EventProviderInterface $eventProvider)
    {
        $this->userRepository = $userRepository;
        $this->eventProvider = $eventProvider;
    }

    /**
     * @access public
     * @param CommandInterface $command
     * @return void
     */
    public function handle(CommandInterface $command)
    {
        $email = Email::create($command->email());

        $user = $this->userRepository->findByEmail($email);

        $this->userRepository->remove($user);

        $this->eventProvider->record(new UserHasBeenRemovedEvent());
    }
}
