<?php

namespace App\Tests\Service;

use App\Entity\Learn_phpunit\Dinosaur;
use App\Entity\Learn_phpunit\Enclosure;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class EnclosureBuilderServiceProphecyTest extends TestCase
{

    public function testItBuildsAndPersistsEnclosure()
    {

        $entityManager = $this->prophesize(EntityManagerInterface::class);
        $entityManager->persist(Argument::type(Enclosure::class))
            ->shouldBeCalledTimes(1);
        $entityManager->flush()->shouldBeCalled();

        $dinoFactory = $this->prophesize(DinosaurFactory::class);
        $dinoFactory->growFromSpecification(Argument::type('string'))
            ->shouldBeCalledTimes(2)
            ->willReturn(new Dinosaur())
            ;

        $builder = new EnclosureBuilderService(
            $entityManager->reveal(),
            $dinoFactory->reveal()
        );
        $enclosure = $builder->buildEnclosure(1, 2);
        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }
}