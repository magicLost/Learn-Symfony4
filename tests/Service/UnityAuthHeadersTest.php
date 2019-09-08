<?php

namespace App\Tests\Service;

use App\Service\UnityAuthHeaders;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;


class UnityAuthHeadersTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function testCheckUrlAndDecode()
    {
        //dump(get_class(self::$container->get(RouterInterface::class)));
        $authHeaders = new UnityAuthHeaders(self::$container->get(RouterInterface::class));

        $client = static::createClient();
        //$client->followRedirect();

        $crawler = $client->request(
            "GET",
            "/ru/test",
            [],
            [],
            [
                "HTTP_accept-language" => "ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7"
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $res = $this->invokePrivateMethod($authHeaders, 'checkPageUrl', [$client->getRequest()]);

        $this->assertEquals( true, $res);

        $hashes_array = $this->invokePrivateMethod($authHeaders, 'decode', [$client->getRequest()]);

        $this->assertEquals( 32, strlen($hashes_array[0]));
        $this->assertEquals( 3, count($hashes_array));

        //$this->invokePrivateMethod($authHeaders, 'setHeaders', [$client->getResponse(), $hashes_array]);

        $this->assertEquals($hashes_array[0], $client->getResponse()->headers->get('policy'));


    }

    public function testMain()
    {
        //dump(get_class(self::$container->get(RouterInterface::class)));
        $authHeaders = new UnityAuthHeaders(self::$container->get(RouterInterface::class));

        $client = static::createClient();
        //$client->followRedirect();

        $crawler = $client->request(
            "GET",
            "/ru/test",
            [],
            [],
            [
                "HTTP_accept-language" => "ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7"
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());




    }

    public function invokePrivateMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function getEntityManager(){
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ;
    }
}