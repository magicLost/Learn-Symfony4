<?php

namespace App\DataFixtures;


use App\Entity\Score;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class ScoreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*$score = new Score();
        $score->setScore(rand(11, 2300));
        $score->setName("Robot".rand(1, 100));

        $manager->persist($score);
        $manager->flush();*/

        $loader = new NativeLoader();

        $objectSet = $loader->loadFile(
            __DIR__ . '/fixtures.yaml'
        );

        //dump($objectSet->getObjects());

        foreach ($objectSet->getObjects() as $score) {
            $manager->persist($score);
            $manager->flush();
        }

    }

}