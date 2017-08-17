<?php

namespace Tests\Application\DataTransformer;

use Application\DataTransformer\SignUpUserDataTransformer;
use CoreBundle\Infrastructure\Service\FormatConverter\NonFormat;
use Domain\Model\Entity\User;
use Domain\Model\ValueObject\Email;
use Mockery as m;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SignUpUserDataTransformerTest
 * @group application
 * @group application_data_transformer
 * @group unit_test
 * @package Tests\Application\DataTransformer
 */
class SignUpUserDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_user_array_with_email()
    {
        $formatConverter = new NonFormat();
        $userStub = m::mock(User::class);
        $email = 'aaa@aaa.com';
        $userStub->shouldReceive('email')->andReturn(Email::create($email));
        $dataTransformer = new SignUpUserDataTransformer($formatConverter, $userStub);

        $data = $dataTransformer->transform();

        $this->assertCount(3, $data);
        $this->assertEquals($data['code'], JsonResponse::HTTP_CREATED);
        $this->assertEquals($data['status'], 'success');
        $this->assertCount(1, $data['data']);
        $this->assertEquals($data['data']['email'], $email);
    }
}
