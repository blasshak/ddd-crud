<?php

namespace Tests\Domain\Model\ValueObject;

use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Exception\InvalidEmailException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class EmailTest
 * @group domain
 * @group domain_model
 * @group domain_model_value_object
 * @group unit_test
 * @package Tests\Domain\Model\ValueObject
 */
class EmailTest extends TestCase
{
    public function test_should_require_email()
    {
        $this->expectException('Exception');

        Email::create();
    }

    public function test_should_require_valid_email()
    {
        $this->expectException(InvalidEmailException::class);

        Email::create('this_is_not_a_valid_email');
    }

    public function test_should_accept_valid_email()
    {
        $value = 'name@domain.com';

        $email = Email::create($value);

        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals($value, $email);
    }
}
