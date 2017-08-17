<?php

namespace Tests\Application\Service;

use Application\Service\EditUser;
use CoreBundle\Domain\Bus\Command\CommandBusInterface;
use Domain\Model\Entity\User;
use Mockery as m;

/**
 * Class EditUserTest
 * @group application
 * @group application_service
 * @group unit_test
 * @package Tests\Application\Service
 */
class EditUserTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_edit_user()
    {
        $userStub = m::mock(User::class);
        $commandBusStub = m::mock(CommandBusInterface::class);
        $commandBusStub->shouldReceive('preHandle')->andReturnNull();
        $commandBusStub->shouldReceive('handle')->andReturn($userStub);
        $editUser = new EditUser(array());
        $editUser->setCommandBus($commandBusStub);
        $request = array('email' => 'a', 'old_password' => 'b', 'new_password' => '', 'repeat_new_password' => '');

        $user = $editUser->execute($request);

        $this->assertInstanceOf(User::class, $user);
    }
}
