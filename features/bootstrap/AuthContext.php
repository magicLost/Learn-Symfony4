<?php

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelDictionary;
use App\Entity\Auth\User;
use Behat\Behat\Tester\Exception\PendingException;


class AuthContext extends RawMinkContext implements Context
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
     * @BeforeScenario
     */
    public function clearData()
    {
        $entityManager = $this->getEntityManager();

        $entity_login = $entityManager->getRepository(User::class)->findOneBy(['username' => 'admin']);

        if($entity_login){

            $entityManager->remove($entity_login);
            $entityManager->flush();

        }

        $entity_register = $entityManager->getRepository(User::class)->findOneBy(['username' => 'Rick']);

        if($entity_register){

            $entityManager->remove($entity_register);
            $entityManager->flush();

        }
        //$purger = new ORMPurger($entityManager);
        //$purger->purge();
    }

    private function getPage()
    {
        return $this->getSession()->getPage();
    }


    /**
     * @Given there is an admin user :username with password :password ahd with email :email
     */
    public function thereIsAnAdminUserWithPasswordAhdWithEmail($username, $password, $email)
    {
        $entityManager = $this->getEntityManager();

        $user = new \App\Entity\Auth\User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setRoles(['ROLE_ADMIN']);


        //dump($entityManager->getConnection()->getDatabase());

        $entityManager->persist($user);
        $entityManager->flush();

        $connection = $entityManager->getConnection();
        $sql = '
          UPDATE  fos_user SET enabled=:enabled WHERE username=:name
        ';
        $stmt = $connection->prepare($sql);
        $stmt->execute(['enabled' => 1, 'name' => 'admin']);

    }

    /**
     * @Given I am logged in as an admim
     */
    public function iAmLoggedInAsAnAdmim()
    {
        //create admin user in DB
        $this->thereIsAnAdminUserWithPasswordAhdWithEmail('admin', 'admin', 'admin@mail.ru');

        //$this->getSession()->visit('/login');
        $this->visitPath('/login');

        try{

            $this->getPage()->fillField('username', 'admin');
            $this->getPage()->fillField('password', 'admin');
            $this->getPage()->pressButton('Login');


        }catch(\Exception $exception){

            throw new PendingException($exception->getMessage());

        }

    }

    /**
     * @Given I am logged in as an user
     */
    public function iAmLoggedInAsAnUser()
    {

        //create user in DB
        //$this->thereIsAnAdminUserWithPasswordAhdWithEmail('admin', 'admin', 'admin@mail.ru');

        //$this->getSession()->visit('/login');
        $this->visitPath('/ru/login');

        try{

            $this->getPage()->fillField('username', 'sia');
            $this->getPage()->fillField('password', '13');
            $this->getPage()->pressButton('_submit');


        }catch(\Exception $exception){

            throw new PendingException($exception->getMessage());

        }


        //throw new PendingException();
    }

    //REGISTRATION

    /**
     * @When I fill in email field with :email
     */
    public function iFillInEmailFieldWith($email)
    {
        $this->getPage()->fillField("fos_user_registration_form_email", $email);

        //throw new PendingException();
    }

    /**
     * @When I fill in username field with :name
     */
    public function iFillInUsernameFieldWith($name)
    {
        $this->getPage()->fillField("fos_user_registration_form_username", $name);
    }

    /**
     * @When I fill in password field with :password
     */
    public function iFillInPasswordFieldWith($password)
    {
        $this->getPage()->fillField("fos_user_registration_form_plainPassword_first", $password);
    }

    /**
     * @When I fill in repeat password field with :password
     */
    public function iFillInRepeatPasswordFieldWith($password)
    {
        $this->getPage()->fillField("fos_user_registration_form_plainPassword_second", $password);
    }

    /**
     * @When I fill in first name field with :firstName
     */
    public function iFillInFirstNameFieldWith($firstName)
    {
        $this->getPage()->fillField("fos_user_registration_form_firstName", $firstName);
    }

    /**
     * @When I press registration button
     */
    public function iPressRegistrationButton()
    {
        try{

            $this->getPage()->pressButton("Зарегистрироваться");

        }catch (Exception $exception){

            $this->getPage()->pressButton("Register");

        }
    }

    //END REGISTRATION




    private function getEntityManager() : \Doctrine\ORM\EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

}