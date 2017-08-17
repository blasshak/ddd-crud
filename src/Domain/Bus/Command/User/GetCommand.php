<?php

namespace Domain\Bus\Command\User;

use CoreBundle\Domain\Bus\Command\CommandInterface;
use Domain\Bus\Command\Exception\InvalidRequestException;

/**
 * Class GetCommand
 * @package Domain\Bus\Command\User
 */
class GetCommand implements CommandInterface
{
    /**
     * @access private
     * @var string
     */
    private $id;

    /**
     * @access private
     * @param array $request
     */
    private function __construct(array $request)
    {
        $this->id = $request['id'];
    }

    /**
     * @access public
     * @param array $request
     * @return static
     * @throws InvalidRequestException
     */
    public static function create(array $request)
    {
        if (empty($request['id'])) {
            throw new InvalidRequestException(InvalidRequestException::MESSAGE);
        }

        return new static($request);
    }

    /**
     * @access public
     * @return string
     */
    public function id() : string
    {
        return $this->id;
    }
}
