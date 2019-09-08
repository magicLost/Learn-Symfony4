<?php

namespace App\Service;

use App\Entity\Learn_phpunit\Enclosure;
use App\Entity\Learn_phpunit\Security;
use App\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DinosaurFactory
     */
    private $dinosaurFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        DinosaurFactory $dinosaurFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->dinosaurFactory = $dinosaurFactory;
    }

    public function buildEnclosure(
        int $numberOfSecuritySystems = 1,
        int $numberOfDinosaurs = 3
    ): Enclosure
    {
        $enclosure = new Enclosure();

        $this->addSecuritySystems($numberOfSecuritySystems, $enclosure);

        $this->addDinosaurs($numberOfDinosaurs, $enclosure);

        
        //dump($this->entityManager->getConnection()->getParams());die;

        $this->entityManager->persist($enclosure);

        $this->entityManager->flush();

        return $enclosure;
    }

    private function addSecuritySystems(int $numberOfSecuritySystems, Enclosure $enclosure)
    {
        $array_of_names = ['Fence', 'Electric fence', 'Guard tower'];

        for ($i = 0; $i < $numberOfSecuritySystems; $i++) {
            $securityName = $array_of_names[$i];
            $security = new Security($securityName, true, $enclosure);

            $enclosure->addSecurity($security);
        }
    }

    private function addDinosaurs(int $numberOfDinosaurs, Enclosure $enclosure)
    {
        $array_of_length = ['small', 'large', 'huge'];
        $array_of_diets = ['herbivore', 'carnivorous'];
        $diet = $array_of_diets[array_rand($array_of_diets)];

        for ($i = 0; $i < $numberOfDinosaurs; $i++) {
            $length = $array_of_length[$i];

            $specification = "{$length} {$diet} dinosaur";
            $dinosaur = $this->dinosaurFactory->growFromSpecification($specification);

            $enclosure->addDinosaur($dinosaur);
        }
    }
}