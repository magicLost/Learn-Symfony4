<?php

namespace App\Controller\Manager;

use App\Entity\Admin\Company;
use App\Entity\Admin\User;
use App\Form\CompanyFormType;
use App\Form\UserForm;
use App\Repository\Admin\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EditController extends Controller
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
     * @Route("/manager/user/{id}/edit", name="manager_user_edit")
     */
    public function user_edit(Request $request, User $user)
    {

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'User updated - you are amazing...');

            return $this->redirectToRoute('manager_show_users');

        }

        return $this->render('manager/edit_user.html.twig', [
            'title' => 'Edit user information',
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/manager/company/{id}/edit", name="manager_company_edit")
     */
    public function company_edit(Request $request, Company $company)
    {
        $form = $this->createForm(CompanyFormType::class, $company);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Company updated - you are amazing...');

            return $this->redirectToRoute('manager_show_companies');

        }

        return $this->render('manager/edit_company.html.twig', [
            'title' => 'Edit company information',
            'companyForm' => $form->createView()
        ]);
    }
}