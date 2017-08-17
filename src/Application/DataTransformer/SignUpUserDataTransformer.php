<?php

namespace Application\DataTransformer;

use CoreBundle\Application\DataTransformer\DataTransformerInterface;
use CoreBundle\Infrastructure\Service\FormatConverter\FormatConverterInterface;
use Domain\Model\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SignUpUserDataTransformer
 * @package Application\DataTransformer
 */
class SignUpUserDataTransformer implements DataTransformerInterface
{
    /**
     * @access private
     * @var FormatConverterInterface
     */
    private $formatConverter;

    /**
     * @access private
     * @var User
     */
    private $user;

    /**
     * @access public
     * @param FormatConverterInterface $formatConverter
     * @param User $user
     */
    public function __construct(FormatConverterInterface $formatConverter, User $user)
    {
        $this->formatConverter = $formatConverter;
        $this->user = $user;
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
                'email' => $this->user->email()
            ]
        );

        return $this->formatConverter->convert($data);
    }
}
