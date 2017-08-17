<?php

namespace Test\Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use CoreBundle\Infrastructure\Bus\Command\Middleware\MiddlewareInterface;
use Domain\Bus\Command\Exception\AuthenticationException;
use Domain\Bus\Command\User\AuthenticationMiddleware;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Exception\InvalidEmailException;
use Domain\Model\ValueObject\Exception\InvalidPasswordException;
use Domain\Repository\UserRepositoryInterface;
use Mockery as m;

/**
 * Class AuthenticationMiddlewareTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Test\Domain\Bus\Command\User
 */
class AuthenticationMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @access private
     * @var m\MockInterface
     */
    private $repositoryStub;

    /**
     * @access private
     * @var callable
     */
    private $lastCallable;


    public function setUp()
    {
        $this->repositoryStub = $this->createUserRepositoryStub();
        $this->lastCallable = function () {
            return true;
        };
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

    public function test_should_return_false_because_email_is_not_valid()
    {
        $email = 'aaa';
        $password = 'Gsdff23232';
        $command = $this->createCommandStub($email, $password);
        $middleware = $this->createAuthenticationMiddleware();
        $this->repositoryStub->shouldReceive('findByEmailAndPassword')->andReturn(null);

        $this->expectException(InvalidEmailException::class);

        $middleware->execute($command, $this->lastCallable);
    }

    public function test_should_return_false_because_password_is_not_valid()
    {
        $email = 'aaa@aaa.com';
        $password = 'sa';
        $command = $this->createCommandStub($email, $password);
        $middleware = $this->createAuthenticationMiddleware();
        $this->repositoryStub->shouldReceive('findByEmailAndPassword')->andReturn(null);

        $this->expectException(InvalidPasswordException::class);

        $middleware->execute($command, $this->lastCallable);
    }

    public function test_should_throw_authentication_exception()
    {
        $email = 'aaa@aaa.com';
        $password = 'Gsdff23232';
        $command = $this->createCommandStub($email, $password);
        $middleware = $this->createAuthenticationMiddleware();
        $this->repositoryStub->shouldReceive('findByEmailAndPassword')->andReturn(null);

        $this->expectException(AuthenticationException::class);

        $middleware->execute($command, $this->lastCallable);
    }

    public function test_should_succeed()
    {
        $email = 'aaa@aaa.com';
        $password = 'Gsdff23232';
        $command = $this->createCommandStub($email, $password);
        $middleware = $this->createAuthenticationMiddleware();
        $user = $this->createUserStub();
        $this->repositoryStub->shouldReceive('findByEmailAndPassword')->andReturn($user);

        $results = $middleware->execute($command, $this->lastCallable);

        $this->assertTrue($results);
    }

    /**
     * @access private
     * @param string $email
     * @param string $password
     * @return CommandInterface
     */
    private function createCommandStub($email, $password)
    {
        $command = m::mock(CommandInterface::class);

        $command->shouldReceive('email')->andReturn($email);
        $command->shouldReceive('password')->andReturn($password);

        return $command;
    }

    /**
     * @access private
     * @return User
     */
    private function createUserStub()
    {
        $user = m::mock(User::class);

        return $user;
    }

    /**
     * @access public
     * @return MiddlewareInterface
     */
    private function createAuthenticationMiddleware()
    {
        $middleware = new AuthenticationMiddleware($this->repositoryStub);

        return $middleware;
    }
}
