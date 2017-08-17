<?php

namespace Domain\Specification\User;

use Domain\Model\ValueObject\Email;
use Domain\Repository\UserRepositoryInterface;
use Domain\Specification\SpecificationInterface;

/**
 * Class EmailIsUnique
 * @package Domain\Specification\User
 */
class EmailIsUnique implements SpecificationInterface
{
    /**
     * @access private
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @access private
     * @var Email
     */
    private $email;

    /**
     * @access public
     * @param UserRepositoryInterface $userRepository
     * @param Email $email
     */
    public function __construct(UserRepositoryInterface $userRepository, Email $email)
    {
        $this->userRepository = $userRepository;
        $this->email = $email;
    }

    /**
     * @access public
     * @return bool
     */
    public function isSatisfied()
    {
        if (empty($this->userRepository->findByEmail($this->email))) {
            return true;
        }

        return false;
    }
}
