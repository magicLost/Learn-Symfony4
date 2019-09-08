<?php

namespace App\Tests\Controller\Learn_phpunit;

use App\Entity\Learn_phpunit\Security;
use Doctrine\ORM\EntityManager;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Throwable;

class MainControllerTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();

    }

    public function testEnclosuresAreShownOnHomepage()
    {

        $fixtures = $this->loadFixtureFiles([
            __DIR__.'/../../../src/DataFixtures/ORM_test/phpunit_fixtures.yaml'
        ]);

        /** @var EntityManager $entityManager */
        /*$entityManager = $this->getEntityManager();

        $enclosures = $entityManager->getRepository(Security::class)->findAll();

        dump($enclosures);*/

        //dump($fixtures['enclosure_1']);

        $client = $this->createClient();
        $crawler = $client->request("GET", "/phpunit");

        $this->assertStatusCode(200, $client);

        $selector = sprintf('#enclosure-%s', $fixtures['enclosure_2']->getId());

        //dump( $crawler->filter($selector)->filter('.wer')->count());
        //dump($client->getResponse()->getContent());

        $this->assertCount(
            3,
            $crawler->filter('table.table-enclosures')->filter('tbody tr'));

        $this->assertGreaterThan(0, $crawler->filter($selector)->filter('.btnm-danger')->count());


    }

    public function testItGrowsADinosaurFromSpecification()
    {
        $fixtures = $this->loadFixtureFiles([
            __DIR__.'/../../../src/DataFixtures/ORM_test/phpunit_fixtures.yaml'
        ]);

        $client = $this->createClient();
        $client->followRedirects();

        $crawler = $client->request("GET", "/phpunit");

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton("Grow dinosaur")->form();
        $form['enclosure']->select(3);
        $form['specification']->setValue('large herbivore');

        $client->submit($form);

        $this->assertContains(
            'Grew a large herbivore in enclosure #3',
            $client->getResponse()->getContent()
        );


    }



    public function getEntityManager(   ){
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ;
    }

}