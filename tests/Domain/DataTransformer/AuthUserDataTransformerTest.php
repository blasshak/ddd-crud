<?php

namespace Tests\Domain\DataTransformer;

use Domain\DataTransformer\AuthUserDataTransformer;
use Domain\Model\Entity\User;
use Mockery as m;

/**
 * Class AuthUserDataTransformerTest
 * @group domain
 * @group domain_data_transformer
 * @group unit_test
 * @package Tests\Domain\DataTransformer
 */
class AuthUserDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_create_new_user()
    {
        $user = m::mock(User::class);
        $user->shouldReceive('id')->andReturn('id');
        $user->shouldReceive('username')->andReturn('username');
        $user->shouldReceive('email')->andReturn('email');
        $authUserDataTransformer = new AuthUserDataTransformer($user);

        $authUser = $authUserDataTransformer->transform();

        $this->assertCount(3, $authUser);
        $this->assertEquals($user->id(), $authUser['id']);
        $this->assertEquals($user->username(), $authUser['username']);
        $this->assertEquals($user->email(), $authUser['email']);
    }
}
