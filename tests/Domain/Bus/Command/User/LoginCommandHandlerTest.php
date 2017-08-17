<?php

namespace Tests\Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Security\TokenInterface;
use Domain\Bus\Command\User\LoginCommand;
use Domain\Bus\Command\User\LoginCommandHandler;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Exception\InvalidEmailException;
use Domain\Repository\UserRepositoryInterface;
use Mockery as m;

/**
 * Class LoginCommandHandlerTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class LoginCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_throw_exception_because_email_is_not_valid()
    {
        $request = array('email' => 'sss', 'password' => 'Gasdf34353');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $tokenStub = $this->createTokenStub();
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $tokenStub);

        $this->expectException(InvalidEmailException::class);

        $commandHandler->handle($command);
    }

    public function test_token_collaborator()
    {
        $request = array('email' => 'prueba@hotmail.com', 'password' => 'Fsdfdsf23123');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmailAndPassword')->andReturn($this->createUserStub());
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn($this->createUserStub());
        $tokenStub = $this->createTokenStub();
        $tokenStub->shouldReceive('create')->times(1)->andReturnNull();
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $tokenStub);

        $commandHandler->handle($command);

        $tokenStub->mockery_verify();
    }

    /**
     * @access private
     * @return User
     */
    private function createUserStub()
    {
        $user = m::mock(User::class);
        $user->shouldReceive('createAuth')->andReturn(array());

        return $user;
    }


    /**
     * @access private
     * @return m\MockInterface
     */
    private function createUserRepositoryStub()
    {
        $repositoryStub = m::mock(UserRepositoryInterface::class);

        return $repositoryStub;
    }

    /**
     * @access private
     * @return TokenInterface
     */
    private function createTokenStub()
    {
        $token = m::mock(TokenInterface::class);

        return $token;
    }

    /**
     * @access private
     * @param array $request
     * @return CommandInterface
     */
    private function createCommand($request)
    {
        $command = LoginCommand::create($request);

        return $command;
    }

    /**
     * @access private
     * @param UserRepositoryInterface $userRepositoryStub
     * @param TokenInterface $tokenStub
     * @return CommandHandlerInterface
     */
    private function createCommandHandler(UserRepositoryInterface $userRepositoryStub, TokenInterface $tokenStub)
    {
        $commandHandler = new LoginCommandHandler($userRepositoryStub, $tokenStub);

        return $commandHandler;
    }
}
