<?php

namespace App\DataFixtures;

use App\Entity\Learn_phpunit\Enclosure;
use App\Entity\Learn_phpunit\Security;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSecurityData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $herbivorousEnclosure = $this->getReference('herbivorous-enclosure');

        $this->addSecurity($herbivorousEnclosure, 'Fence', true);

        $carnivorousEnclosure = $this->getReference('carnivorous-enclosure');

        $this->addSecurity($carnivorousEnclosure, 'Electric fence', false);
        $this->addSecurity($carnivorousEnclosure, 'Guard tower', false);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    private function addSecurity(
        Enclosure $enclosure,
        string $name,
        bool $isActive
    )
    {
        $enclosure->addSecurity(new Security($name, $isActive, $enclosure));
    }
}
