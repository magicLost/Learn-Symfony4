<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 05.04.2018
 * Time: 18:12
 */

namespace App\Tests\Entity\Learn_phpunit;


use App\Entity\Learn_phpunit\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function setUp(){
        $this->dinosaur = new Dinosaur();
    }

    public function testReturnsFullSpecificationOfDinosaur()
    {
        $this->assertSame(
            'The Unknown non-carnivorous dinosaur is 0 meters long',
            $this->dinosaur->getSpecification()
        );
    }

    public function testReturnsFullSpecificationForTyrannosaurus()
    {
        $dinosaur = new Dinosaur('Tyrannosaurus', true);

        $dinosaur->setLength(12);

        $this->assertSame(
            'The Tyrannosaurus carnivorous dinosaur is 12 meters long',
            $dinosaur->getSpecification()
        );
    }

    /*public function testTest(int $number)
    {
        $this->assertSame(2, $number);
    }*/
}