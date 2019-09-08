<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\RawMinkContext;


//require __DIR__.'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class CommandLineProcessContext extends RawMinkContext implements Context
{

    private $output;

    public function __construct()
    {
    }

    /**
     * @BeforeScenario
     */
    public function moveInToTestDir(){
        if(!is_dir('behat_test')){
            mkdir('behat_test');
        }
        chdir('behat_test');
    }

    /**
     * @AfterScenario
     */
    public function moveOutOfTestDir(){
        chdir('..');
        if(is_dir('behat_test')){
            system('rmdir behat_test /s');
        }
    }

    /**
     * @Given there is a file named :filename
     */
    public function thereIsAFileNamed($filename)
    {
        if(!touch($filename))
            throw new PendingException("Файл не touch");
    }

    /**
     * @When I run :command
     */
    public function iRun($command)
    {
        $this->output = shell_exec($command);
        if($this->output === null)
            throw new PendingException("Can not run commmand - ".$command);

    }

    /**
     * @Then I should see :result in the output
     */
    public function iShouldSeeInTheOutput($result)
    {

        if(strpos($this->output, $result) === false)
            throw new PendingException("Файл не найден - ".$result);


        /*assertContains(
            $result,
            $this->output,
            sprintf('Did not see %s in the output %s', $result, $this->output)
        );*/
    }

    /**
     * @Given there is a dir named :dir
     */
    public function thereIsADirNamed($dir)
    {
        if(mkdir($dir) === false)
            throw new PendingException("Can not make dir with name - ".$dir);

    }

}
