<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Infrastructure\Bus\Command\Middleware\MiddlewareInterface;
use Domain\Bus\Command\Exception\AuthenticationException;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Password;
use Domain\Repository\UserRepositoryInterface;

/**
 * Class AuthenticationMiddleware
 * @package Domain\Bus\Command\User
 */
class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * @access private
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @access public
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @access public
     * @param CommandInterface $command
     * @param callable $next
     * @return mixed
     * @throws \Exception
     */
    public function execute(CommandInterface $command, callable $next)
    {
        try {
            $email = Email::create($command->email());
            $password = Password::create($command->password());

            $this->authenticate($email, $password);

            $returnValue = $next($command);
        } catch (\Exception $e) {
            throw $e;
        }

        return $returnValue;
    }

    /**
     * @access private
     * @param Email $email
     * @param Password $password
     * @return void
     * @throws AuthenticationException
     */
    private function authenticate(Email $email, Password $password)
    {
        $user = $this->userRepository->findByEmailAndPassword($email, $password);

        if (empty($user)) {
            throw new AuthenticationException(AuthenticationException::MESSAGE);
        }
    }
}
