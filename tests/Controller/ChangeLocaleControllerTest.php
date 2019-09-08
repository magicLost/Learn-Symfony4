<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChangeLocaleControllerTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function testMain()
    {
        $client = static::createClient();
        //$client->followRedirect();

        $crawler = $client->request(
            "GET",
            "/",
            [],
            [],
            [
                "HTTP_accept-language" => "ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7"
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //dump($client->getRequest()->headers);

        $this->assertEquals('ru', $client->getRequest()->getSession()->get("_locale"));

        $locale_form = $crawler->filter('option:contains("ru")')->parents()->parents()->form();

        $this->assertEquals('POST', $locale_form->getMethod());

        $this->assertEquals('ru', $client->getRequest()->getSession()->get("_locale"));

        $crawler = $client->submit($locale_form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $this->assertEquals('', $client->getRequest()->getSession()->get("_locale"));
        //dump($crawler->getUri());

    }
}