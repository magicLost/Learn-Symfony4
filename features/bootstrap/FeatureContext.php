<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use App\Entity\Auth\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;


//require __DIR__.'/../../bin/.phpunit/phpunit-6.5/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{

    use KernelDictionary;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * Pauses the scenario until the user presses a key. Useful when debugging a scenario.
     *
     * @Then (I )put a breakpoint
     */
    public function iPutABreakpoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while (fgets(STDIN, 1024) == '') {
        }
        fwrite(STDOUT, "\033[u");
        return;
    }

    /**
     * @Given there is/are :count product(s)
     */
    public function thereAreProducts($count){
        //$this->createProducts($count);
    }

    /**
     * @Given the following products exists:
     */
    public function theFollowingProductsExists(TableNode $table)
    {
        foreach ($table as $row){
            dump($row);
        }
    }

    /**
     * @BeforeScenario @fixtures
     */
    public function loadFixtures()
    {
        $loader = new \Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader($this->getContainer());
        $loader->loadFromFile(__DIR__.'/../../src/DataFixtures/AppFixtures.php');

        $executor = new ORMExecutor($this->getEntityManager(), new ORMPurger($this->getEntityManager()));
        $executor->execute($loader->getFixtures());
    }

    /**
     * @Then the :rowText row should have a check mark
     */
    public function theRowShouldHaveACheckMark($rowText)
    {
        $row = $this->getSession()->getPage()->find('css', sprintf('table tr:contains("%s")', $rowText));
        assertNotNull($row, 'Could not find a row with text '.$rowText);

        assertContains('fa-check', $row->getHtml(), 'Did not find the check...');
    }

    private function getEntityManager() : \Doctrine\ORM\EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

}
