<?php

namespace Test\Domain\Bus\Command\User;

use Domain\Bus\Command\Exception\InvalidRequestException;
use Domain\Bus\Command\User\EditCommand;

/**
 * Class EditCommandTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Test\Domain\Bus\Command\User
 */
class EditCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_require_valid_params()
    {
        $request = array();

        $this->expectException(InvalidRequestException::class);

        EditCommand::Create($request);
    }

    public function test_should_require_valid_email()
    {
        $request = array('old_password' => 'b', 'new_password' => '', 'repeat_new_password' => '');

        $this->expectException(InvalidRequestException::class);

        EditCommand::create($request);
    }

    public function test_should_require_email_not_empty()
    {
        $request = array('email' => '', 'old_password' => 'b', 'new_password' => 'sss', 'repeat_new_password' => 'ss');

        $this->expectException(InvalidRequestException::class);

        EditCommand::create($request);
    }

    public function test_should_require_valid_password()
    {
        $request = array('email' => 'a', 'new_password' => '', 'repeat_new_password' => '');

        $this->expectException(InvalidRequestException::class);

        EditCommand::create($request);
    }

    public function test_should_require_valid_new_password()
    {
        $request = array('email' => 'a', 'old_password' => 'b', 'repeat_new_password' => '');

        $this->expectException(InvalidRequestException::class);

        EditCommand::create($request);
    }

    public function test_should_require_valid_repeat_new_password()
    {
        $request = array('email' => 'a', 'old_password' => 'b', 'new_password' => '');

        $this->expectException(InvalidRequestException::class);

        EditCommand::create($request);
    }

    public function test_should_create_new_command()
    {
        $request = array('email' => 'a', 'old_password' => 'b', 'new_password' => '', 'repeat_new_password' => '');

        $command = EditCommand::create($request);

        $this->assertEquals($request['email'], $command->email());
        $this->assertEquals($request['old_password'], $command->oldPassword());
        $this->assertEquals($request['new_password'], $command->newPassword());
        $this->assertEquals($request['repeat_new_password'], $command->repeatNewPassword());
        $this->assertInstanceOf(EditCommand::class, $command);
    }
}
