<?php

namespace Tests\Application\DataTransformer;

use Application\DataTransformer\ExceptionDataTransformer;
use CoreBundle\Infrastructure\Service\FormatConverter\JsonFormat;
use CoreBundle\Infrastructure\Service\FormatConverter\NonFormat;
use Mockery as m;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ExceptionDataTransformerTest
 * @group application
 * @group application_data_transformer
 * @group unit_test
 * @package Tests\Application\DataTransformer
 */
class ExceptionDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_user_array_with_email()
    {
        $formatConverter = new NonFormat();
        $message = 'aaa@aaa.com';
        $dataTransformer = new ExceptionDataTransformer($formatConverter, $message);

        $data = $dataTransformer->transform();

        $this->assertCount(3, $data);
        $this->assertEquals($data['code'], JsonResponse::HTTP_BAD_REQUEST);
        $this->assertEquals($data['status'], 'error');
        $this->assertEquals($data['message'], $message);
    }
}
