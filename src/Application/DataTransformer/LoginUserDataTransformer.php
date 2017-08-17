<?php

namespace Application\DataTransformer;

use CoreBundle\Application\DataTransformer\DataTransformerInterface;
use CoreBundle\Infrastructure\Service\FormatConverter\FormatConverterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LoginUserDataTransformer
 * @package Application\DataTransformer
 */
class LoginUserDataTransformer implements DataTransformerInterface
{
    /**
     * @access private
     * @var FormatConverterInterface
     */
    private $formatConverter;

    /**
     * @access private
     * @var string
     */
    private $token;

    /**
     * @access public
     * @param FormatConverterInterface $formatConverter
     * @param string $token
     */
    public function __construct(FormatConverterInterface $formatConverter, string $token)
    {
        $this->formatConverter = $formatConverter;
        $this->token = $token;
    }

    /**
     * @access public
     * @return mixed
     */
    public function transform()
    {
        $data = array(
            'code' => JsonResponse::HTTP_CREATED,
            'status' => 'success',
            'data' => [
                'token' => $this->token
            ]
        );

        return $this->formatConverter->convert($data);
    }
}
