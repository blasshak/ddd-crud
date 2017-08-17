<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use Domain\Bus\Command\Exception\InvalidRequestException;

/**
 * Class LoginCommand
 * @package Domain\Bus\Command\User
 */
class LoginCommand implements CommandInterface
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
    private $password;

    /**
     * @access private
     * @param array $request
     */
    private function __construct(array $request)
    {
        $this->email = $request['email'];
        $this->password = $request['password'];
    }

    /**
     * @access public
     * @param array $request
     * @return static
     * @throws InvalidRequestException
     */
    public static function create(array $request)
    {
        if (empty($request['email']) || empty($request['password'])) {
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
    public function password() : string
    {
        return $this->password;
    }
}
