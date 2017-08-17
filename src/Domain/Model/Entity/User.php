<?php

namespace Domain\Model\Entity;

use Domain\DataTransformer\AuthUserDataTransformer;
use Domain\Model\ValueObject\Email;
use Domain\Model\ValueObject\HashedPassword;
use Domain\Model\ValueObject\Id;

/**
 * Class User
 * @package Domain\Model\Entity
 */
class User
{
    /**
     * @access private
     * @var Id
     */
    private $id;

    /**
     * @access private
     * @var Email
     */
    private $email;

    /**
     * @access private
     * @var HashedPassword
     */
    private $password;

    /**
     * @access private
     * @param Id $id
     * @param Email $email
     * @param HashedPassword $hashedPassword
     */
    private function __construct(Id $id, Email $email, HashedPassword $hashedPassword)
    {
        $this->setId($id);
        $this->setEmail($email);
        $this->setPassword($hashedPassword);
    }

    /**
     * @access public
     * @param Id $id
     * @param Email $email
     * @param HashedPassword $hashedPassword
     * @return User
     */
    public static function register(Id $id, Email $email, HashedPassword $hashedPassword) : self
    {
        return new static($id, $email, $hashedPassword);
    }

    /**
     * @access public
     * @return string
     */
    public function id()
    {
        return $this->id->value();
    }

    /**
     * @access private
     * @param Id $id
     * @return void
     */
    private function setId(Id $id)
    {
        $this->id = $id;
    }

    /**
     * @access private
     * @param Email $email
     * @return void
     */
    private function setEmail(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @access public
     * @return string
     */
    public function email()
    {
        return $this->email->value();
    }

    /**
     * @access private
     * @param HashedPassword $hashedPassword
     * @return void
     */
    private function setPassword(HashedPassword $hashedPassword)
    {
        $this->password = $hashedPassword;
    }

    /**
     * @access public
     * @return string
     */
    public function password()
    {
        return $this->password->value();
    }

    /**
     * @access public
     * @param HashedPassword $newPassword
     * @return void
     */
    public function updateProfile(HashedPassword $newPassword)
    {
        $this->changePassword($newPassword);
    }

    /**
     * @access private
     * @param HashedPassword $newPassword
     * @return void
     */
    private function changePassword(HashedPassword $newPassword)
    {
        if (!empty($newPassword->value())) {
            $this->setPassword($newPassword);
        }
    }

    /**
     * @acess public
     * @return array
     */
    public function createAuth()
    {
        $authUserDataTransformer = new AuthUserDataTransformer($this);

        return $authUserDataTransformer->transform();
    }
}
