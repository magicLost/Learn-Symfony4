<?php

namespace App\Tests\Entity\Learn_phpunit;

use App\Entity\Learn_phpunit\Dinosaur;
use App\Entity\Learn_phpunit\Enclosure;
use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;

class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure();
        $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs());

    }

    /**
     * expectedException \App\Exception\NotABuffetException
     */
    public function testItDoesNotAllowCarnivorousDinosToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());
        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));

    }

    public function testItDoesNotAllowToAddDinosToUnsecureEnclosures()
    {
        $enclosure = new Enclosure(false);
        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you craaazy?!?');
        $enclosure->addDinosaur(new Dinosaur());
    }

    /*
     * @dataProvider getParamsToSimpleTest
     */
    /*public function testSimpleTest(int $number){

        $dinosaur = new DinosaurTest("testTest", [ $number ]);
        $dinosaur->runTest();

    }

    public function getParamsToSimpleTest()
    {
        return [
            [2],
            [4]
        ];
    }*/
}