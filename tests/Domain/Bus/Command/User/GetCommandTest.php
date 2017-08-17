<?php

namespace Test\Domain\Bus\Command\User;

use Domain\Bus\Command\Exception\InvalidRequestException;
use Domain\Bus\Command\User\GetCommand;

/**
 * Class GetCommandTest
 * @group domain
 * @group domain_Bus
 * @group domain_Bus_command
 * @group domain_Bus_command_user
 * @group unit_test
 * @package Tests\Domain\Bus\Command\User
 */
class GetCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_require_valid_params()
    {
        $request = array();

        $this->expectException(InvalidRequestException::class);

        GetCommand::create($request);
    }

    public function test_should_require_id_not_empty()
    {
        $request = array('id' => '');

        $this->expectException(InvalidRequestException::class);

        GetCommand::create($request);
    }

    public function test_should_create_new_command()
    {
        $request = array('id' => 'as1');

        $command = GetCommand::create($request);

        $this->assertEquals($request['id'], $command->id());
    }
}
