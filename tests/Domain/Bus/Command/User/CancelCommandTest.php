<?php

namespace Test\Domain\Bus\Command\User;

use Domain\Bus\Command\Exception\InvalidRequestException;
use Domain\Bus\Command\User\CancelCommand;

/**
 * Class CancelCommandTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class CancelCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_require_valid_params()
    {
        $request = array();

        $this->expectException(InvalidRequestException::class);

        CancelCommand::create($request);
    }

    public function test_should_require_email()
    {
        $request = array('password' => 'as');

        $this->expectException(InvalidRequestException::class);

        CancelCommand::create($request);
    }

    public function test_should_require_email_not_empty()
    {
        $request = array('email' => '', 'password' => 'as');

        $this->expectException(InvalidRequestException::class);

        CancelCommand::create($request);
    }

    public function test_should_require_password()
    {
        $request = array('email' => 'as');

        $this->expectException(InvalidRequestException::class);

        CancelCommand::create($request);
    }

    public function test_should_require_password_not_empty()
    {
        $request = array('email' => 'as', 'password' => '');

        $this->expectException(InvalidRequestException::class);

        CancelCommand::create($request);
    }

    public function test_should_create_new_command()
    {
        $request = array('email' => 'as1', 'password' => 'as2');

        $command = CancelCommand::create($request);

        $this->assertEquals($request['email'], $command->email());
        $this->assertEquals($request['password'], $command->password());
        $this->assertInstanceOf(CancelCommand::class, $command);
    }
}
