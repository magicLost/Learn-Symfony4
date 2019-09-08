<?php

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelDictionary;
use App\Entity\Score\Score;

class ScoreContext extends RawMinkContext implements Context
{

    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        $entityManager = $this->getEntityManager();

        $entity = $entityManager->getRepository(Score::class)->findOneBy(['name' => 'Miley']);

        if($entity){

            $entityManager->remove($entity);
            $entityManager->flush();

        }
    }

    /**
     * @When I wait for the modal to load
     */
    public function iWaitForTheModalToLoad()
    {

        $this->getSession()->wait(
            5000,
            "$('div#result').css('display') === 'block'" // if this returns true, then wait stops
        );
    }

    private function getEntityManager() : \Doctrine\ORM\EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

}