<?php

namespace App\Controller\Manager;

use App\Entity\Admin\Company;
use App\Entity\Admin\User;
use App\Repository\Admin\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowController extends Controller
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/manager/users", name="manager_show_users")
     */
    public function show_users()
    {
        /**@var UserRepository $user_repository */

        $user_repository = $this->entityManager->getRepository(User::class);

        //$users = $user_repository->findLastFifty();

        $users = $user_repository->findAll();

        return $this->render('manager/show_users.html.twig', [
            'title' => 'Our users',
            'users' => $users
        ]);
    }

    /**
     * @Route("/manager/companies", name="manager_show_companies")
     */
    public function show_companies()
    {
        /**@var UserRepository $user_repository */

        $company_repository = $this->entityManager->getRepository(Company::class);

        //$users = $user_repository->findLastFifty();

        $companies = $company_repository->findAll();

        return $this->render('manager/show_companies.html.twig', [
            'title' => 'Our companies',
            'companies' => $companies
        ]);
    }
}
