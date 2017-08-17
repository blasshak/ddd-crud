<?php

namespace Domain\Repository;

use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\Password;

/**
 * Class interface
 * @package Domain\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @access public
     * @param Email $email
     * @return User
     */
    public function findByEmail(Email $email);

    /**
     * @access public
     * @param Email $email
     * @param Password $password
     * @return User
     */
    public function findByEmailAndPassword(Email $email, Password $password);

    /**
     * @access public
     * @param User $user
     * @return void
     */
    public function add(User $user);

    /**
     * @access public
     * @param User $user
     * @return void
     */
    public function remove(User $user);
}
