<?php

namespace App\Controller\Manager;


use App\Entity\Admin\User;
use App\Form\UserForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddController extends Controller
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
     * @Route("/manager/user/add", name="manager_user_add")
     */
    public function user_edit(Request $request)
    {

        $form = $this->createForm(UserForm::class, new User());

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'User added - you are amazing...');

            return $this->redirectToRoute('manager_show_users');

        }

        return $this->render('manager/add_user.html.twig', [
            'title' => 'Add user',
            'userForm' => $form->createView()
        ]);
    }
}