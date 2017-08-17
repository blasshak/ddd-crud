<?php

namespace Application\Service;

use CoreBundle\Application\Service\AbstractApplicationService;
use Domain\Bus\Command\User\GetCommand;

/**
 * Class GetUser
 * @package Application\Service
 */
class GetUser extends AbstractApplicationService
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
        $command = GetCommand::create($request);
        $value = $this->commandBus->handle($command);

        return $value;
    }
}
