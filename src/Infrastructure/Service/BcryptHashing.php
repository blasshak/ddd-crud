<?php

namespace Infrastructure\Service;

use Domain\Model\ValueObject\HashedPassword;
use Domain\Model\ValueObject\Password;
use Domain\Service\HashingInterface;

/**
 * Class BcryptHashing
 * @package Infrastructure\Service
 */
class BcryptHashing implements HashingInterface
{
    /**
     * @access public
     * @param Password $password
     * @return HashedPassword
     */
    public function hash(Password $password) : HashedPassword
    {
        if (empty($password->value())) {
            return HashedPassword::create('');
        }

        return HashedPassword::create(password_hash($password, PASSWORD_BCRYPT, array('cost' => 12)));
    }
}
