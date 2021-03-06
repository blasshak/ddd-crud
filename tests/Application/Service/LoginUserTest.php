<?php

namespace Tests\Application\Service;

use Application\Service\LoginUser;
use CoreBundle\Domain\Bus\Command\CommandBusInterface;
use Domain\Model\Entity\User;
use Mockery as m;

/**
 * Class LoginUserTest
 * @group application
 * @group application_service
 * @group unit_test
 * @package Tests\Application\Service
 */
class LoginUserTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_new_user()
    {
        $userStub = m::mock(User::class);
        $commandBusStub = m::mock(CommandBusInterface::class);
        $commandBusStub->shouldReceive('preHandle')->andReturnNull();
        $commandBusStub->shouldReceive('handle')->andReturn($userStub);
        $signUpUser = new LoginUser(array());
        $signUpUser->setCommandBus($commandBusStub);
        $request = array('email' => 'as1', 'password' => 'as2');

        $user = $signUpUser->execute($request);

        $this->assertInstanceOf(User::class, $user);
    }
}
