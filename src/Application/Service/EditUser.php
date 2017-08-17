<?php

namespace Application\Service;

use CoreBundle\Application\Service\AbstractApplicationService;
use Domain\Bus\Command\User\EditCommand;

/**
 * Class EditUser
 * @package Application\Service
 */
class EditUser extends AbstractApplicationService
{
    /**
     * @access public
     * @param array $middlewares
     */
    public function __construct(array $middlewares)
    {
        parent::__construct($middlewares);
    }

    /**
     * @access public
     * @param array $request
     * @return mixed
     */
    public function execute(array $request)
    {
        $command = EditCommand::create($request);
        $value = $this->commandBus->handle($command);

        return $value;
    }
}
