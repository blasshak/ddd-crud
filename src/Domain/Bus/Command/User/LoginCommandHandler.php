<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Security\TokenInterface;
use Domain\Model\ValueObject\Email;
use Domain\Repository\UserRepositoryInterface;

/**
 * Class LoginCommandHandler
 * @package Domain\Bus\Command\User
 */
class LoginCommandHandler implements CommandHandlerInterface
{
    /**
     * @access private
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @access private
     * @var TokenInterface
     */
    private $token;

    /**
     * @access public
     * @param UserRepositoryInterface $userRepository
     * @param TokenInterface $token
     */
    public function __construct(UserRepositoryInterface $userRepository, TokenInterface $token)
    {
        $this->userRepository = $userRepository;
        $this->token = $token;
    }

    /**
     * @access public
     * @param CommandInterface $command
     * @return String
     */
    public function handle(CommandInterface $command)
    {
        $email = Email::create($command->email());

        $user = $this->userRepository->findByEmail($email);

        return $this->token->create($user->createAuth());
    }
}
