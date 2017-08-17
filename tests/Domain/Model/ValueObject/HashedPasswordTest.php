<?php

namespace Tests\Domain\Model\ValueObject;

use Domain\Model\ValueObject\HashedPassword;
use Domain\Model\ValueObject\Exception\InvalidHashedPasswordException;

/**
 * Class HashedPasswordTest
 * @group domain
 * @group domain_model
 * @group domain_model_value_object
 * @group unit_test
 * @package Tests\Domain\Model\ValueObject
 */
class HashedPasswordTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_accept_valid_empty_hashed_password()
    {
        $hashedPassword = HashedPassword::create('');

        $this->assertEquals('', $hashedPassword);
    }

    public function test_should_accept_valid_hashed_password()
    {
        $value = 'name@domain.com';

        $hashed_password = HashedPassword::create($value);

        $this->assertInstanceOf(HashedPassword::class, $hashed_password);
        $this->assertEquals($value, $hashed_password);
    }
}
