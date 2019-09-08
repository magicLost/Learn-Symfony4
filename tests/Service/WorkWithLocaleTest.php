<?php

namespace App\Tests\Service;

//use Liip\FunctionalTestBundle\Test\WebTestCase;
use App\Service\WorkWithLocale;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WorkWithLocaleTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function testFirst()
    {
        $workWithLocale = new WorkWithLocale();
        //$client = $this->createClient();
        $client = static::createClient();

        $crawler = $client->request(
            "GET",
            "/",
            [],
            [],
            [
                "accept-language" => "ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7"
            ]
        );

        $client->getRequest()->headers->set("accept-language", "ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7");
        //$client->getRequest()->getSession()->set("_locale", 'ru');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals('ru', $workWithLocale->getLocale($client->getRequest()));

        $workWithLocale->changeLocale($client->getRequest());

        $this->assertEquals('en', $client->getRequest()->getSession()->get("_locale"));

        $locale_form = $crawler->filter('option:contains("ru")')->parents()->parents()->form();

        //dump($locale_form->getMethod());
        $this->assertEquals('POST', $locale_form->getMethod());


    }
}