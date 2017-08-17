<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Security\UserStorageInterface;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Id;
use Domain\Repository\UserRepositoryInterface;
use Domain\Specification\Exception\PermissionsException;
use Domain\Specification\User\ShowUserInformation;
use Symfony\Component\Security\Core\User\User;

/**
 * Class GetCommandHandler
 * @package Domain\Bus\Command\User
 */
class GetCommandHandler implements CommandHandlerInterface
{
    /**
     * @access private
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @access private
     * @var UserStorageInterface
     */
    private $userStorage;

    /**
     * @access public
     * @param UserRepositoryInterface $userRepository
     * @param UserStorageInterface $userStorage
     */
    public function __construct(UserRepositoryInterface $userRepository, UserStorageInterface $userStorage)
    {
        $this->userRepository = $userRepository;
        $this->userStorage = $userStorage;
    }

    /**
     * @access public
     * @param CommandInterface $command
     * @return User
     * @throws PermissionsException
     */
    public function handle(CommandInterface $command)
    {
        $id = Id::create($command->id());
        $authUser = $this->userStorage->get();
        $idAuth = Id::create($authUser->id());
        $email = Email::create($authUser->email());
        $showUserInformation = new ShowUserInformation($id, $idAuth);

        if (!$showUserInformation->isSatisfied()) {
            throw new PermissionsException(PermissionsException::MESSAGE);
        }

        $user = $this->userRepository->findByEmail($email);

        return $user;
    }
}
