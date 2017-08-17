<?php

namespace Tests\Domain\Specification\User;

use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Domain\Repository\UserRepositoryInterface;
use Domain\Specification\SpecificationInterface;
use Domain\Specification\User\EmailIsUnique;
use Mockery as m;

/**
 * Class EmailIsUniqueTest
 * @group domain
 * @group domain_specification
 * @group domain_specification_user
 * @group unit_test
 * @package Tests\Domain\Specification\User
 */
class EmailIsUniqueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @access private
     * @var Email
     */
    private $email;

    /**
     * @access private
     * @var m\MockInterface
     */
    private $repositoryStub;

    public function setUp()
    {
        $this->email = Email::create('aa@aaa.com');
        $this->repositoryStub = $this->createUserRepositoryStub();
    }

    /**
     * @access private
     * @return m\MockInterface
     */
    private function createUserRepositoryStub()
    {
        $repositoryStub = m::mock(UserRepositoryInterface::class);

        return $repositoryStub;
    }

    public function test_should_return_true_when_unique()
    {
        $specification = $this->createSpecification($this->email);
        $this->repositoryStub->shouldReceive('findByEmail')->andReturn(null);

        $isSatisfied = $specification->isSatisfied();

        $this->assertTrue($isSatisfied);
    }

    public function test_should_return_false_when_not_unique()
    {
        $specification = $this->createSpecification($this->email);
        $user = m::mock(User::class);
        $this->repositoryStub->shouldReceive('findByEmail')->andReturn($user);

        $isSatisfied = $specification->isSatisfied();

        $this->assertFalse($isSatisfied);
    }

    /**
     * @access public
     * @param Email $email
     * @return SpecificationInterface
     */
    private function createSpecification(Email $email)
    {
        $specification = new EmailIsUnique($this->repositoryStub, $email);

        return $specification;
    }
}
