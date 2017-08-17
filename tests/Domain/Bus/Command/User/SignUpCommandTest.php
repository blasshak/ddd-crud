<?php

namespace Test\Domain\Bus\Command\User;

use Domain\Bus\Command\Exception\InvalidRequestException;
use Domain\Bus\Command\User\SignUpCommand;

/**
 * Class SignUpCommandTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class SignUpCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_require_valid_params()
    {
        $request = array();

        $this->expectException(InvalidRequestException::class);

        SignUpCommand::create($request);
    }

    public function test_should_require_email()
    {
        $request = array('password' => 'as', 'repeat_password' => 'as2');

        $this->expectException(InvalidRequestException::class);

        SignUpCommand::create($request);
    }

    public function test_should_require_password()
    {
        $request = array('email' => 'as', 'repeat_password' => 'as2');

        $this->expectException(InvalidRequestException::class);

        SignUpCommand::create($request);
    }

    public function test_should_require_repeat_password()
    {
        $request = array('email' => 'as', 'password' => 'as2');

        $this->expectException(InvalidRequestException::class);

        SignUpCommand::create($request);
    }

    public function test_should_create_new_command()
    {
        $request = array('email' => 'as1', 'password' => 'as2', 'repeat_password' => 'as2');

        $command = SignUpCommand::create($request);

        $this->assertEquals($request['email'], $command->email());
        $this->assertEquals($request['password'], $command->password());
        $this->assertEquals($request['repeat_password'], $command->repeatPassword());
        $this->assertInstanceOf(SignUpCommand::class, $command);
    }
}
