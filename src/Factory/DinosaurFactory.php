<?php

namespace App\Factory;


use App\Entity\Learn_phpunit\Dinosaur;
use App\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    /**
     * @var DinosaurLengthDeterminator
     */
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }


    public function growVelociraptor(int $length): Dinosaur
    {

        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        $codeName = "InG-".random_int(1, 99999);

        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);

        if(stripos($specification, "carnivorous") !== false){
            $isCarnivorous = true;
        }else{
            $isCarnivorous = false;
        }

        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $length)
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }


}