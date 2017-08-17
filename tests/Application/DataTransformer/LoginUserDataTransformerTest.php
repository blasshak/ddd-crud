<?php

namespace Tests\Application\DataTransformer;

use Application\DataTransformer\LoginUserDataTransformer;
use CoreBundle\Infrastructure\Service\FormatConverter\NonFormat;
use Mockery as m;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LoginUserDataTransformerTest
 * @group application
 * @group application_data_transformer
 * @group unit_test
 * @package Tests\Application\DataTransformer
 */
class LoginUserDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_user_array_with_email()
    {
        $formatConverter = new NonFormat();
        $token = 'aa';
        $dataTransformer = new LoginUserDataTransformer($formatConverter, $token);

        $data = $dataTransformer->transform();

        $this->assertCount(3, $data);
        $this->assertEquals($data['code'], JsonResponse::HTTP_CREATED);
        $this->assertEquals($data['status'], 'success');
        $this->assertCount(1, $data['data']);
        $this->assertEquals($data['data']['token'], $token);
    }
}
