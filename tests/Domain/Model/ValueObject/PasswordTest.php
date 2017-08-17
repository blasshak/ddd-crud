<?php

namespace Tests\Domain\Model\ValueObject;

use Domain\Model\ValueObject\Password;
use Domain\Model\ValueObject\Exception\InvalidPasswordException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class PasswordTest
 * @group domain
 * @group domain_model
 * @group domain_model_value_object
 * @group unit_test
 * @package Tests\Domain\Model\ValueObject
 */
class PasswordTest extends TestCase
{
    public function test_should_require_password()
    {
        $this->expectException('Exception');

        Password::create();
    }

    public function test_should_require_valid_password()
    {
        $this->expectException(InvalidPasswordException::class);

        Password::create('1');
    }

    /** RegEx (?=\S{8,}) */
    public function test_should_require_valid_password_at_least_length_8()
    {
        $this->expectException(InvalidPasswordException::class);

        Password::create('Ee12345');
    }

    /** RegEx (?=\S*[a-z]) */
    public function test_should_require_valid_password_containing_at_least_one_lowercase_letter()
    {
        $this->expectException(InvalidPasswordException::class);

        Password::create('EE123456');
    }

    /** RegEx (?=\S*[A-Z]) */
    public function test_should_require_valid_password_containing_at_least_one_uppercase_letter()
    {
        $this->expectException(InvalidPasswordException::class);

        Password::create('ee123456');
    }

    /** RegEx (?=\S*[\d]) */
    public function test_should_require_valid_password_at_least_one_number()
    {
        $this->expectException(InvalidPasswordException::class);

        Password::create('Eeeeeeee');
    }

    /** RegEx (?=\S{8,}) */
    public function test_should_accept_valid_password()
    {
        $value = 'Ee123456';

        $password = Password::create($value);

        $this->assertInstanceOf(Password::class, $password);
        $this->assertEquals($value, $password);
    }

    public function test_password_and_repeatPassword_should_not_be_equal()
    {
        $password = Password::create('Ee123456');
        $repeatPassword = Password::create('Ee123457');

        $this->expectException(InvalidPasswordException::class);

        $password->checkPasswordAndRepeatPasswordAreEquals($repeatPassword);
    }

    public function test_password_and_repeatPassword_should_be_equal()
    {
        $password = Password::create('Ee123456');
        $repeatPassword = Password::create('Ee123456');

        $password->checkPasswordAndRepeatPasswordAreEquals($repeatPassword);
    }
}
