<?php

namespace App\Tests\Service;


use App\Entity\Learn_phpunit\Dinosaur;
use App\Entity\Learn_phpunit\Enclosure;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class))
        ;

        $dinoFactory->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->with($this->isType('string'))
            ->willReturn(new Dinosaur())
        ;

        $builder = new EnclosureBuilderService($em, $dinoFactory);
        /**
         * @var Enclosure
         */
        $enclosure = $builder->buildEnclosure(1, 2);

        //dump($enclosure->getDinosaurs()->toArray());

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }


}