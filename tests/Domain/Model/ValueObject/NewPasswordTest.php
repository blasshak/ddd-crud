<?php

namespace Tests\Domain\Model\ValueObject;

use Domain\Model\ValueObject\NewPassword;
use Domain\Model\ValueObject\Exception\InvalidPasswordException;
use Domain\Model\ValueObject\Password;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class NewPasswordTest
 * @group domain
 * @group domain_model
 * @group domain_model_value_object
 * @group unit_test
 * @package Tests\Domain\Model\ValueObject
 */
class NewPasswordTest extends TestCase
{
    public function test_should_require_valid_password()
    {
        $this->expectException(InvalidPasswordException::class);

        NewPassword::create('1');
    }

    public function test_should_be_instance_of_password_as_well()
    {
        $newPassword = NewPassword::create();

        $this->assertInstanceOf(Password::class, $newPassword);
    }

    public function test_should_create_newPassword()
    {
        $newPassword = NewPassword::create();

        $this->assertEquals('', $newPassword);
    }
}
