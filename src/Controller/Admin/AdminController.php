<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Company;
use App\Entity\Admin\User;
use App\Entity\Admin\UserCompany;
use App\Entity\Learn\FortuneCookie;
use App\Entity\Score\ScoreComment;
use App\Form\CookieFormType;
use App\Service\ArrayHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    public function __construct(EntityManagerInterface $entityManager, ArrayHelper $arrayHelper)
    {
        $this->entityManager = $entityManager;
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * @Route("/admin", name="admin_home")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'title' => 'Administration',
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function work_with_users(Request $request)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneById(24);

        if(!$user ){
            throw $this->createNotFoundException('Not found user');
        }

        return $this->render('admin/users.html.twig', [
            'title' => 'Work with users',
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/remove_user/{user_id}/company/{company_id}", name="admin_delete_company", requirements={"user_id"="\d+", "company_id"="\d+"})
     */
    public function removeCompany($user_id, $company_id)
    {
        /**@var Company $company */
        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['id' => $company_id]);

        if(!$company){
            throw $this->createNotFoundException('Not found company');
        }

        /**@var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $user_id]);

        if(!$user){
            throw $this->createNotFoundException('Not found user');
        }

        $user->removeCompany($company);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        //
        /*$user_company = $this->entityManager->getRepository(UserCompany::class)->findOneBy([
            'user' => $user_id,
            'company' => $company_id
        ]);

        $this->entityManager->remove($user_company);
        $this->entityManager->flush();*/
        //

        return new Response(null, 204);
    }

    /**
     * @Route("/admin/add_cookie", name="admin_add_cookie")
     */
    public function add_cookie(Request $request)
    {
        $form = $this->createForm(CookieFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //dump($form->getData());die;
            $cookie = $form->getData();

            $this->entityManager->persist($cookie);
            $this->entityManager->flush();

            $this->addFlash('success', 'Cookie created - you are amazing...');

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/add_cookie.html.twig', [
            'title' => 'Administrate add cookie',
            'cookieForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="admin_edit_cookie")
     */
    public function edit_cookie(Request $request, FortuneCookie $cookie)
    {
        $form = $this->createForm(CookieFormType::class, $cookie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //dump($form->getData());die;
            $cookie = $form->getData();

            $this->entityManager->persist($cookie);
            $this->entityManager->flush();

            $this->addFlash('success', 'Cookie updated - you are amazing...');

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/edit_cookie.html.twig', [
            'title' => 'Administrate edit cookie',
            'cookieForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/comments", name="admin_comments")
     */
    public function comments()
    {
        $comments = $this->entityManager->getRepository(ScoreComment::class)->findAllCommentsJoinScoreName();

        $comments = $this->arrayHelper->sortArrayByNames($comments);

        return $this->render('admin/comments.html.twig', [
            'title' => 'Administrate comments',
            'comments' => $comments
        ]);
    }



}
