<?php

namespace Tests\Domain\Model\Entity;

use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\HashedPassword;
use Domain\Model\ValueObject\Id;

/**
 * Class UserTest
 * @group domain
 * @group domain_model
 * @group domain_model_entity
 * @group unit_test
 * @package Tests\Domain\Model\Entity
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_create_new_user()
    {
        $id = Id::create();
        $email = Email::create('aa@aaa.com');
        $hashedPasswoxrd = HashedPassword::create('s');

        $user = User::register($id, $email, $hashedPasswoxrd);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($id->value(), $user->id());
        $this->assertEquals($email->value(), $user->email());
    }

    public function test_should_not_update_profice()
    {
        $id = Id::create();
        $email = Email::create('aa@aaa.com');
        $hashedPasswoxrd = HashedPassword::create('s');
        $user = User::register($id, $email, $hashedPasswoxrd);
        $newHashedPasswoxrd = HashedPassword::create('');

        $user->updateProfile($newHashedPasswoxrd);

        $this->assertEquals($hashedPasswoxrd->value(), $user->password());
    }

    public function test_should_update_profice()
    {
        $id = Id::create();
        $email = Email::create('aa@aaa.com');
        $hashedPasswoxrd = HashedPassword::create('s');
        $user = User::register($id, $email, $hashedPasswoxrd);
        $newHashedPasswoxrd = HashedPassword::create('ss');

        $user->updateProfile($newHashedPasswoxrd);

        $this->assertNotEquals($hashedPasswoxrd->value(), $user->password());
    }
}
