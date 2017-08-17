<?php

namespace Tests\Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandHandlerInterface;
use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Domain\Bus\Event\EventProviderInterface;
use Domain\Bus\Command\User\CancelCommand;
use Domain\Bus\Command\User\CancelCommandHandler;
use Domain\Bus\Event\User\UserHasBeenRemovedEvent;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Exception\InvalidEmailException;
use Domain\Repository\UserRepositoryInterface;
use Mockery as m;

/**
 * Class CancelCommandHandlerTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class CancelCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_throw_exception_because_email_is_not_valid()
    {
        $request = array('email' => 'sss', 'password' => 'Gasdf34353');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $eventProviderStub = $this->createEventProviderStub();
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $eventProviderStub);

        $this->expectException(InvalidEmailException::class);

        $commandHandler->handle($command);
    }

    public function test_user_repository_collaborator()
    {
        $request = array('email' => 'prueba@hotmail.com', 'password' => 'Fsdfdsf23123');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->times(1)->andReturn($this->createUserStub());
        $userRepositoryStub->shouldReceive('remove')->times(1)->andReturn($this->createUserStub());
        $eventProviderStub = $this->createEventProviderStub();
        $eventProviderStub->shouldReceive('record');
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $eventProviderStub);

        $commandHandler->handle($command);

        $userRepositoryStub->mockery_verify();
    }

    public function test_event_provider_collaborator()
    {
        $request = array('email' => 'prueba@hotmail.com', 'password' => 'Fsdfdsf23123');
        $command = $this->createCommand($request);
        $userRepositoryStub = $this->createUserRepositoryStub();
        $userRepositoryStub->shouldReceive('findByEmail')->andReturn($this->createUserStub());
        $userRepositoryStub->shouldReceive('remove')->andReturn($this->createUserStub());
        $eventProviderStub = $this->createEventProviderStub();
        $eventProviderStub->shouldReceive('record')->times(1)->with(UserHasBeenRemovedEvent::class);
        $commandHandler = $this->createCommandHandler($userRepositoryStub, $eventProviderStub);

        $commandHandler->handle($command);

        $eventProviderStub->mockery_verify();
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
        $command = CancelCommand::create($request);

        return $command;
    }

    /**
     * @access private
     * @param UserRepositoryInterface $userRepositoryStub
     * @param EventProviderInterface $eventProvider
     * @return CommandHandlerInterface
     */
    private function createCommandHandler(
        UserRepositoryInterface $userRepositoryStub,
        EventProviderInterface $eventProvider
    ) {
        $commandHandler = new CancelCommandHandler($userRepositoryStub, $eventProvider);

        return $commandHandler;
    }
}
