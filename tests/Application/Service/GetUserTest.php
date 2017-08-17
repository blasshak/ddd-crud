<?php

namespace Tests\Application\Service;

use Application\Service\GetUser;
use CoreBundle\Domain\Bus\Command\CommandBusInterface;
use Domain\Model\Entity\User;
use Mockery as m;

/**
 * Class GetUserTest
 * @group application
 * @group application_service
 * @group unit_test
 * @package Tests\Application\Service
 */
class GetUserTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_new_user()
    {
        $userStub = m::mock(User::class);
        $commandBusStub = m::mock(CommandBusInterface::class);
        $commandBusStub->shouldReceive('preHandle')->andReturnNull();
        $commandBusStub->shouldReceive('handle')->andReturn($userStub);
        $signUpUser = new GetUser(array());
        $signUpUser->setCommandBus($commandBusStub);
        $request = array('id' => 'as1');

        $user = $signUpUser->execute($request);

        $this->assertInstanceOf(User::class, $user);
    }
}
