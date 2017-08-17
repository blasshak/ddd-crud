<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Event\EventProviderInterface;
use Domain\Bus\Event\User\UserHasBeenEditedEvent;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\NewPassword;
use Domain\Repository\UserRepositoryInterface;
use Domain\Service\HashingInterface;

/**
 * Class EditCommandHandler
 * @package Domain\Bus\Command\User
 */
class EditCommandHandler implements CommandHandlerInterface
{
    /**
     * @access private
     * @var HashingInterface
     */
    private $hashing;

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
     * @param HashingInterface $hashing
     * @param UserRepositoryInterface $userRepository
     * @param EventProviderInterface $eventProvider
     */
    public function __construct(
        HashingInterface $hashing,
        UserRepositoryInterface $userRepository,
        EventProviderInterface $eventProvider
    ) {
        $this->hashing = $hashing;
        $this->userRepository = $userRepository;
        $this->eventProvider = $eventProvider;
    }

    /**
     * @access public
     * @param CommandInterface $command
     * @return User
     */
    public function handle(CommandInterface $command)
    {
        $email = Email::create($command->email());
        $newPassword = NewPassword::create($command->newPassword());
        $repeatNewPassword = NewPassword::create($command->repeatNewPassword());

        $newPassword->checkPasswordAndRepeatPasswordAreEquals($repeatNewPassword);

        $user = $this->userRepository->findByEmail($email);

        $hashedNewPassword = $this->hashing->hash($newPassword);

        $user->updateProfile($hashedNewPassword);

        $this->userRepository->add($user);

        $this->eventProvider->record(new UserHasBeenEditedEvent());

        return $user;
    }
}
