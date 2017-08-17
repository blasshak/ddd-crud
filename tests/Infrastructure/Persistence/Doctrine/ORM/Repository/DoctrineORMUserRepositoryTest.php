<?php

namespace Tests\Infrastructure\Persistence\Doctrine\ORM\Repository;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Password;
use Infrastructure\Persistence\Doctrine\ORM\Repository\DoctrineORMUserRepository;
use Mockery as m;

/**
 * Class DoctrineORMUserRepositoryTest
 * @group unit_test
 * @package Tests\Infrastructure\Persistence\Doctrine\ORM\Repository
 */
class DoctrineORMUserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @todo test
     */
    public function atest_should_return_null_when_email_is_not_valid()
    {
        $userRepository = $this->createUserRepository();

        $email = Email::create('aa@aaa.com');
        $password = Password::create('Eads25871');

        $user = $userRepository->findByEmailAndPassword($email, $password);
        var_dump($user);
        //$this->assertEquals(null, );
    }

    /**
     * @access private
     * @return DoctrineORMUserRepository
     */
    private function createUserRepository()
    {
        $em = m::mock(EntityManager::class);
        $userRepository = new DoctrineORMUserRepository($em, m::mock(ClassMetadata::class));

        return $userRepository;
    }
}
