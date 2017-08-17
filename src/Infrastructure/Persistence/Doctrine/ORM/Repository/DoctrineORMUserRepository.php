<?php

namespace Infrastructure\Persistence\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Password;
use Domain\Repository\UserRepositoryInterface;

/**
 * Class DoctrineORMUserRepository
 * @package Infrastructure\Persistence\Doctrine\ORM\Repository
 */
class DoctrineORMUserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @access public
     * @param Email $email
     * @return User
     */
    public function findByEmail(Email $email)
    {
        return $this->findOneBy(['email.value' => $email->value()]);
    }

    /**
     * @access public
     * @param Email $email
     * @param Password $password
     * @return User
     */
    public function findByEmailAndPassword(Email $email, Password $password)
    {
        $user = $this->findByEmail($email);

        if (empty($user)) {
            return null;
        }

        if (!password_verify($password->value(), $user->password())) {
            return null;
        }

        return $user;
    }

    /**
     * @access public
     * @param User $user
     * @return void
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
    }

    /**
     * @access public
     * @param User $user
     * @return void
     */
    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
    }
}
