<?php

namespace Tests\Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Event\EventProviderInterface;
use CoreBundle\Infrastructure\ValueObject\AbstractValueObject;
use Domain\Bus\Command\User\SignUpCommand;
use Domain\Bus\Command\User\SignUpCommandHandler;
use Domain\Bus\Event\User\UserHasBeenSignedUpEvent;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Exception\InvalidPasswordException;
use Domain\Model\ValueObject\HashedPassword;
use Domain\Repository\UserRepositoryInterface;
use Domain\Service\HashingInterface;
use Domain\Specification\Exception\ValueIsNotUniqueException;
use Mockery as m;

/**
 * Class SignUpCommandHandlerTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class SignUpCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_throw_exception_because_password_and_repeat_password_are_not_equals()
    {
        $request = array('email' => 'aas@hotmail.com', 'password' => 'Aas1234567s', 'repeat_password' => 'Aas1234567');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn($this->createUserStub());
        $hashingStub = $this->createHashingStub();
        $eventProviderStub = $this->createEventProviderStub();
        $commandHandler = $this->createCommandHandler($hashingStub, $userRepositoryStub, $eventProviderStub);


        $this->expectException(InvalidPasswordException::class);

        $commandHandler->handle($command);
    }

    public function test_should_throw_exception_because_user_is_already_registered()
    {
        $request = array('email' => 'aas@hotmail.com', 'password' => 'Aas1234567', 'repeat_password' => 'Aas1234567');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn($this->createUserStub());
        $hashingStub = $this->createHashingStub();
        $eventProviderStub = $this->createEventProviderStub();
        $commandHandler = $this->createCommandHandler($hashingStub, $userRepositoryStub, $eventProviderStub);

        $this->expectException(ValueIsNotUniqueException::class);

        $commandHandler->handle($command);
    }

    public function test_hashing_collaborator()
    {
        $request = array('email' => 'aas@hotmail.com', 'password' => 'Aas1234567', 'repeat_password' => 'Aas1234567');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn(null);
        $userRepositoryStub->shouldReceive('add');
        $hashingStub = $this->createHashingStub();
        $hashedPassword = $this->createHashedPassword();
        $hashingStub->shouldReceive('hash')->times(1)->andReturn($hashedPassword);
        $eventProviderStub = $this->createEventProviderStub();
        $eventProviderStub->shouldReceive('record');

        $commandHandler = $this->createCommandHandler($hashingStub, $userRepositoryStub, $eventProviderStub);

        $commandHandler->handle($command);

        $hashingStub->mockery_verify();
    }

    public function test_user_repository_collaborator()
    {
        $request = array('email' => 'aas@hotmail.com', 'password' => 'Aas1234567', 'repeat_password' => 'Aas1234567');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->times(1);
        $userRepositoryStub->shouldReceive('add')->times(1)->with(User::class);
        $hashingStub = $this->createHashingStub();
        $hashedPassword = $this->createHashedPassword();
        $hashingStub->shouldReceive('hash')->andReturn($hashedPassword);
        $eventProviderStub = $this->createEventProviderStub();
        $eventProviderStub->shouldReceive('record');
        $commandHandler = $this->createCommandHandler($hashingStub, $userRepositoryStub, $eventProviderStub);

        $commandHandler->handle($command);

        $userRepositoryStub->mockery_verify();
    }

    public function test_event_provider_collaborator()
    {
        $request = array('email' => 'aas@hotmail.com', 'password' => 'Aas1234567', 'repeat_password' => 'Aas1234567');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn(null);
        $userRepositoryStub->shouldReceive('add');
        $hashingStub = $this->createHashingStub();
        $hashedPassword = $this->createHashedPassword();
        $hashingStub->shouldReceive('hash')->andReturn($hashedPassword);
        $eventProviderStub = $this->createEventProviderStub();
        $eventProviderStub->shouldReceive('record')->times(1)->with(UserHasBeenSignedUpEvent::class);
        $commandHandler = $this->createCommandHandler($hashingStub, $userRepositoryStub, $eventProviderStub);

        $commandHandler->handle($command);

        $eventProviderStub->mockery_verify();
    }

    public function test_should_succeed()
    {
        $request = array('email' => 'aas@hotmail.com', 'password' => 'Aas1234567', 'repeat_password' => 'Aas1234567');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn(null);
        $userRepositoryStub->shouldReceive('add');
        $hashingStub = $this->createHashingStub();
        $hashedPassword = $this->createHashedPassword();
        $hashingStub->shouldReceive('hash')->andReturn($hashedPassword);
        $eventProviderStub = $this->createEventProviderStub();
        $eventProviderStub->shouldReceive('record');
        $commandHandler = $this->createCommandHandler($hashingStub, $userRepositoryStub, $eventProviderStub);

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
     * @return m\MockInterface
     */
    private function createUserRepositoryStub()
    {
        $repositoryStub = m::mock(UserRepositoryInterface::class);

        return $repositoryStub;
    }

    /**
     * @access private
     * @return AbstractValueObject
     */
    private function createHashedPassword()
    {
        return HashedPassword::create('');
    }

    /**
     * @access private
     * @return m\MockInterface
     */
    private function createHashingStub()
    {
        $hashingStub = m::mock(HashingInterface::class);

        return $hashingStub;
    }

    /**
     * @access private
     * @return EventProviderInterface
     */
    private function createEventProviderStub()
    {
        $eventProviderStub = m::mock(EventProviderInterface::class);

        return $eventProviderStub;
    }

    /**
     * @access private
     * @param array $request
     * @return CommandInterface
     */
    private function createCommand($request)
    {
        $command = SignUpCommand::create($request);

        return $command;
    }

    /**
     * @access private
     * @param HashingInterface $hashingStub
     * @param UserRepositoryInterface $userRepositoryStub
     * @param EventProviderInterface $eventProvider
     * @return CommandHandlerInterface
     */
    private function createCommandHandler(
        HashingInterface $hashingStub,
        UserRepositoryInterface $userRepositoryStub,
        EventProviderInterface $eventProvider
    ) {
        $commandHandler = new SignUpCommandHandler($hashingStub, $userRepositoryStub, $eventProvider);

        return $commandHandler;
    }
}
