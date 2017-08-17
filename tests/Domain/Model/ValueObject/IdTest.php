<?php

namespace Tests\Domain\Model\ValueObject;

use Domain\Model\ValueObject\Id;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class IdTest
 * @group domain
 * @group domain_model
 * @group domain_model_value_object
 * @group unit_test
 * @package Tests\Domain\Model\ValueObject
 */
class IdTest extends TestCase
{
    public function test_should_accept_default_id()
    {
        $id = Id::create();

        $this->assertInstanceOf(Id::class, $id);
    }

    public function test_should_accept_valid_id()
    {
        $value = 's';

        $id = Id::create($value);

        $this->assertInstanceOf(Id::class, $id);
        $this->assertEquals($value, $id);
    }
}
