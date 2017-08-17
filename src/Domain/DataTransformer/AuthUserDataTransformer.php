<?php

namespace Domain\DataTransformer;

use CoreBundle\Application\DataTransformer\DataTransformerInterface;
use Domain\Model\Entity\User;

/**
 * Class AuthUserDataTransformer
 * @package Domain\DataTransformer
 */
class AuthUserDataTransformer implements DataTransformerInterface
{
    /**
     * @access private
     * @var User
     */
    private $user;

    /**
     * @access public
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @access public
     * @return mixed
     */
    public function transform()
    {
        $data = array(
            'id' => $this->user->id(),
            'username' => 'username',
            'email' => $this->user->email()
        );

        return $data;
    }
}
