<?php

namespace Application\Service;

use CoreBundle\Application\Service\AbstractApplicationService;
use Domain\Bus\Command\User\SignUpCommand;

/**
 * Class SignUpUser
 * @package Application\Service
 */
class SignUpUser extends AbstractApplicationService
{
    /**
     * @access public
     */
    public function __construct()
    {
        parent::__construct(array());
    }

    /**
     * @access public
     * @param array $request
     * @return mixed
     */
    public function execute(array $request)
    {
        $command = SignUpCommand::create($request);
        $value = $this->commandBus->handle($command);

        return $value;
    }
}
