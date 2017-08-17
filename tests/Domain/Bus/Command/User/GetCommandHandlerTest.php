<?php

namespace Tests\Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Security\Model\Entity\AuthUserInterface;
use CoreBundle\Domain\Security\UserStorageInterface;
use Domain\Bus\Command\User\GetCommand;
use Domain\Bus\Command\User\GetCommandHandler;
use Domain\Model\Entity\User;
use Domain\Repository\UserRepositoryInterface;
use Domain\Specification\Exception\PermissionsException;
use Mockery as m;

/**
 * Class GetCommandHandlerTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class GetCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_throw_permissions_exception()
    {
        $id = 'a';
        $authId = 'b';
        $email = 'as@asd.com';
        $authUser = $this->createAuthUserStub($authId, $email);
        $request = array('id' => $id);
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userStorage = $this->createUserStorageStub($authUser);
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $userStorage);

        $this->expectException(PermissionsException::class);

        $commandHandler->handle($command);
    }

    public function test_user_repository_collaborator()
    {
        $id = 'a';
        $authId = 'a';
        $email = 'as@asd.com';
        $authUser = $this->createAuthUserStub($authId, $email);
        $request = array('id' => $id);
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->times(1)->andReturn($this->createUserStub());
        $userStorage = $this->createUserStorageStub($authUser);
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $userStorage);

        $commandHandler->handle($command);

        $userRepositoryStub->mockery_verify();
    }

    public function test_should_succeed()
    {
        $id = 'a';
        $authId = 'a';
        $email = 'as@asd.com';
        $authUser = $this->createAuthUserStub($authId, $email);
        $request = array('id' => $id);
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->times(1)->andReturn($this->createUserStub());
        $userStorage = $this->createUserStorageStub($authUser);
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $userStorage);

        $user = $commandHandler->handle($command);

        $this->assertInstanceOf(User::class, $user);
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
     * @param string $id
     * @param string $email
     * @return User
     */
    private function createAuthUserStub(string $id, string $email)
    {
        $user = m::mock(AuthUserInterface::class);

        $user->shouldReceive('id')->andReturn($id);
        $user->shouldReceive('email')->andReturn($email);

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
     * @param AuthUserInterface $authUser
     * @return UserStorageInterface
     */
    private function createUserStorageStub(AuthUserInterface $authUser)
    {
        $userStorageStub = m::mock(UserStorageInterface::class);

        $userStorageStub->shouldReceive('get')->andReturn($authUser);

        return $userStorageStub;
    }

    /**
     * @access private
     * @param array $request
     * @return CommandInterface
     */
    private function createCommand($request)
    {
        $command = GetCommand::create($request);

        return $command;
    }

    /**
     * @access private
     * @param UserRepositoryInterface $userRepositoryStub
     * @param UserStorageInterface $userStorage
     * @return CommandHandlerInterface
     */
    private function createCommandHandler(
        UserRepositoryInterface $userRepositoryStub,
        UserStorageInterface $userStorage
    ) {
        $commandHandler = new GetCommandHandler($userRepositoryStub, $userStorage);

        return $commandHandler;
    }
}
