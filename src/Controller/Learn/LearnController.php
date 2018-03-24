<?php

namespace App\Controller\Learn;

use App\Entity\Learn\Category;
use App\Entity\Learn\FortuneCookie;
use App\Repository\Learn\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class LearnController extends Controller
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {

        $this->entityManager = $entityManager;
        $this->doctrine = $doctrine;

    }

    /**
     * @Route("/learn", name="learn_homepage")
     */
    public function homepage()
    {
        /** @var CategoryRepository $categoriesRepository */
        $categoriesRepository = $this->entityManager->getRepository(Category::class);

        $categories = $categoriesRepository->findAllWithFortuneCookiesLength();

        return $this->render('learn/homepage.html.twig',[
            'title' => 'Learn doctrine queries',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/learn/{term}", name="learn_category_show")
     */
    public function show_category($term)
    {
        $category = $this->entityManager->getRepository(Category::class)->search($term);

        $printedCategory = $this->entityManager
            ->getRepository(FortuneCookie::class)
            ->countNumberPrintedByCategory($category[0]);



        if (!$category) {
            throw $this->createNotFoundException();
        }

        return $this->render('learn/show_category.html.twig',[
            'title' => "Category",
            'category' => $category,
            'printedCategory' => $printedCategory
        ]);
    }
}
