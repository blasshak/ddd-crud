<?php

namespace Domain\Specification;

/**
 * Interface SpecificationInterface
 * @package Domain\Specification
 */
interface SpecificationInterface
{
    /**
     * @access public
     * @return bool
     */
    public function isSatisfied();
}
