<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 * @group infrastructure
 * @group infrastructure_symfony
 * @group infrastructure_symfony_controller
 * @group integration_test
 * @package Tests\Infrastructure\Service
 */
class DefaultControllerTest extends WebTestCase
{
    private $container;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    public function testIndex()
    {
        /**$userRepository = $this->container->get('infrastructure.user_repository');
        var_dump($userRepository->remove('prueba@hotmail.com'));**/
        $client = static::createClient();

        $parameters = array(
            'email' => 'prueba@hotmail.com',
            'password' => 'Aas1234567'
        );
        //$data['password'] = '22';

        $crawler = $client->request('post', '/', $parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"message":"prueba@hotmail.com is already registered"}', $client->getResponse()->getContent());
    }
}
