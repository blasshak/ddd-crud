<?php

namespace Tests\Domain\Specification\User;

use Domain\Model\ValueObject\Id;
use Domain\Specification\SpecificationInterface;
use Domain\Specification\User\ShowUserInformation;
use Mockery as m;

/**
 * Class ShowUserInformationTest
 * @group domain
 * @group domain_specification
 * @group domain_specification_user
 * @group unit_test
 * @package Tests\Domain\Specification\User
 */
class ShowUserInformationTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_true_when_are_equal()
    {
        $id = Id::create('a');
        $idAuth = Id::create('a');
        $specification = $this->createSpecification($id, $idAuth);

        $isSatisfied = $specification->isSatisfied();

        $this->assertTrue($isSatisfied);
    }

    public function test_should_return_false_when_are_not_equal()
    {
        $id = Id::create('a');
        $idAuth = Id::create('b');
        $specification = $this->createSpecification($id, $idAuth);

        $isSatisfied = $specification->isSatisfied();

        $this->assertFalse($isSatisfied);
    }

    /**
     * @access public
     * @param Id $id
     * @param Id $idAuth
     * @return SpecificationInterface
     */
    private function createSpecification(Id $id, Id $idAuth)
    {
        $specification = new ShowUserInformation($id, $idAuth);

        return $specification;
    }
}
