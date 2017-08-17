<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Event\EventProviderInterface;
use Domain\Bus\Event\User\UserHasBeenSignedUpEvent;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Id;
use Domain\Model\ValueObject\Password;
use Domain\Repository\UserRepositoryInterface;
use Domain\Service\HashingInterface;
use Domain\Specification\Exception\ValueIsNotUniqueException;
use Domain\Specification\User\EmailIsUnique;

/**
 * Class SignUpCommandHandler
 * @package Domain\Bus\Command\User
 */
class SignUpCommandHandler implements CommandHandlerInterface
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
        $id = Id::create();
        $email = Email::create($command->email());
        $password = Password::create($command->password());
        $repeatPassword = Password::create($command->repeatPassword());

        $password->checkPasswordAndRepeatPasswordAreEquals($repeatPassword);
        $this->checkEmailIsUnique($email);

        $hashedPassword = $this->hashing->hash($password);

        $user = User::register($id, $email, $hashedPassword);

        $this->userRepository->add($user);

        $this->eventProvider->record(new UserHasBeenSignedUpEvent());

        return $user;
    }

    /**
     * @access private
     * @param Email $email
     * @return void
     * @throws ValueIsNotUniqueException
     */
    private function checkEmailIsUnique(Email $email)
    {
        $specification = new EmailIsUnique($this->userRepository, $email);

        if (!$specification->isSatisfied()) {
            throw ValueIsNotUniqueException::fromValue($email->value());
        }
    }
}
