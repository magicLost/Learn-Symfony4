<?php

namespace App\Tests\Factory;


use App\Entity\Learn_phpunit\Dinosaur;
use App\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Factory\DinosaurFactory;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $lengthDeterminator;

    public function setUp()
    {

        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
    }

    public function testItGrowsAVelociraptor()
    {
        /**
         * @var $dinosaur Dinosaur
         */
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {
        //$this->lengthDeterminator->method("getLengthFromSpecification")->willReturn(20);
        $this->lengthDeterminator
            ->expects($this->once())
            ->method("getLengthFromSpecification")
            ->with($spec)
            ->willReturn(20)
        ;

        /**
         * @var $dinosaur Dinosaur
         */
        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertSame(20, $dinosaur->getLength());

        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do not match');
    }


    public function getSpecificationTests()
    {
        return [
            'one' => ['large carnivorous dinosaur', true],
            'two' => ['gine me all the cookies', false],
            'three' =>['large herbivore', false],
        ];
    }



    /*public function testItGrowsATriceraptors()
    {
        $this->markTestIncomplete("Waiting for confirmation from GenLab");
    }

    public function testItGrowsABabyVelociraptor()
    {
        /**
         * @var $dinosaur Dinosaur
         */
        /*$dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());

        if (!class_exists(Nanny::class)) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }
    }*/
}