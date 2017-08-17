<?php

namespace Domain\Specification\User;

use Domain\Model\ValueObject\Id;
use Domain\Specification\SpecificationInterface;

/**
 * Class ShowUserInformation
 * @package Domain\Specification\User
 */
class ShowUserInformation implements SpecificationInterface
{
    /**
     * @access private
     * @var Id
     */
    private $userId;

    /**
     * @access private
     * @var Id
     */
    private $idAuth;

    /**
     * @access public
     * @param Id $userId
     * @param Id $idAuth
     */
    public function __construct(Id $userId, Id $idAuth)
    {
        $this->userId = $userId;
        $this->idAuth = $idAuth;
    }

    /**
     * @access public
     * @return bool
     */
    public function isSatisfied()
    {
        if ($this->userId->equals($this->idAuth)) {
            return true;
        }

        return false;
    }
}
