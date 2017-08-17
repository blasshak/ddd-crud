<?php

namespace Domain\Service;

use Domain\Model\ValueObject\HashedPassword;
use Domain\Model\ValueObject\Password;

/**
 * Interface HashingInterface
 * @package Domain\Service
 */
interface HashingInterface
{
    /**
     * Create a new hashed password
     *
     * @param Password $password
     * @return HashedPassword
     */
    public function hash(Password $password);
}
