<?php

namespace Tests\Infrastructure\Service;

use Domain\Model\ValueObject\HashedPassword;
use Domain\Model\ValueObject\NewPassword;
use Domain\Model\ValueObject\Password;
use Infrastructure\Service\BcryptHashing;

/**
 * Class BcryptHashingTest
 * @group infrastructure
 * @group infrastructure_service
 * @group unit_test
 * @package Tests\Infrastructure\Service
 */
class BcryptHashingTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_create_a_empty_hashed_password()
    {
        $service = new BcryptHashing();
        $password = NewPassword::create('');

        $hashed = $service->hash($password);

        $this->assertEquals('', $hashed);
    }

    public function test_should_make_new_hashed_password_instance()
    {
        $service = new BcryptHashing();
        $password = Password::create('Ee123456');

        $hashed = $service->hash($password);

        $this->assertInstanceof(HashedPassword::class, $hashed);
        $this->assertEquals(60, strlen($hashed->value()));
    }
}
