<?php

namespace App\Tests\Service;

use App\Entity\Learn_phpunit\Dinosaur;
use App\Entity\Learn_phpunit\Enclosure;
use App\Entity\Learn_phpunit\Security;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use function foo\func;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    public function setUp()
    {
        self::bootKernel();

        $this->truncateEntities([
            Enclosure::class,
            Dinosaur::class,
            Security::class
        ]);
    }

    public function testItBuildsEnclosureWithDefaultSpecifications()
    {

        /** @var $enclosureBuilderService EnclosureBuilderService */
        /*$enclosureBuilderService = self::$kernel->getContainer()
            ->get('test.'.EnclosureBuilderService::class);*/

        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects($this->any())
            ->method('growFromSpecification')
            ->willReturnCallback(function($spec){
                return new Dinosaur();
            });

        $enclosureBuilderService = new EnclosureBuilderService(
            $this->getEntityManager(),
            $dinoFactory
        );

        $enclosureBuilderService->buildEnclosure();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();

        //dump($entityManager->getConnection()->getParams());die;

        $count = (int)$entityManager
            ->getRepository(Security::class)
            ->createQueryBuilder('security')
            ->Select('COUNT(security.id)')
            ->getQuery()
            ->getSingleScalarResult()
            ;

        $this->assertSame(1, $count, 'Amount of security systems is not the same');

        $count = (int)$entityManager
            ->getRepository(Dinosaur::class)
            ->createQueryBuilder('dino')
            ->Select('COUNT(dino.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $this->assertSame(3, $count, 'Amount of dinosaurs is not the same');

    }

    private function truncateEntities(array $entities)
    {
        $purger = new ORMPurger($this->getEntityManager());

        $purger->purge();
    }

    public function getEntityManager(){
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ;
    }
}