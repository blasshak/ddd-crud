<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use Domain\Bus\Command\Exception\InvalidRequestException;

/**
 * Class EditCommand
 * @package Domain\Bus\Command\User
 */
class EditCommand implements CommandInterface
{
    /**
     * @access private
     * @var string
     */
    private $email;

    /**
     * @access private
     * @var string
     */
    private $oldPassword;

    /**
     * @access private
     * @var string
     */
    private $newPassword;

    /**
     * @access private
     * @var string
     */
    private $repeatNewPassword;

    /**
     * @access private
     * @param array $request
     */
    private function __construct(array $request)
    {
        $this->email = $request['email'];
        $this->oldPassword = $request['old_password'];
        $this->newPassword = $request['new_password'];
        $this->repeatNewPassword = $request['repeat_new_password'];
    }

    /**
     * @access public
     * @param array $request
     * @return static
     * @throws InvalidRequestException
     */
    public static function create(array $request)
    {

        if (empty($request['email'])
            || empty($request['old_password'])
            || !array_key_exists('new_password', $request)
            || !array_key_exists('repeat_new_password', $request)) {
            throw new InvalidRequestException(InvalidRequestException::MESSAGE);
        }

        return new static($request);
    }

    /**
     * @access public
     * @return string
     */
    public function email() : string
    {
        return $this->email;
    }

    /**
     * @access public
     * @return string
     */
    public function oldPassword() : string
    {
        return $this->oldPassword;
    }

    /**
     * @access public
     * @return string
     */
    public function newPassword() : string
    {
        return $this->newPassword;
    }

    /**
     * @access public
     * @return string
     */
    public function repeatNewPassword() : string
    {
        return $this->repeatNewPassword;
    }
}
