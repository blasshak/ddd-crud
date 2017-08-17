<?php

namespace Domain\Model\ValueObject;

use CoreBundle\Infrastructure\ValueObject\AbstractValueObject;
use Rhumsaa\Uuid\Uuid;

/**
 * Class Id
 * @package Domain\Model\ValueObject
 */
class Id extends AbstractValueObject
{
    /**
     * @access protected
     * @param $value
     */
    protected function __construct($value)
    {
        if (empty($value)) {
            $value = Uuid::uuid4()->toString();
        }

        $this->setValue($value);
    }
}
