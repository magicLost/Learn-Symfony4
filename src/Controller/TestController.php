<?php

namespace App\Controller;


use App\Entity\Score;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
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
     * @Route("/test", name="test")
     */
    public function index()
    {

        $scores = $this->doctrine->getRepository(Score::class)->findByTerm('ta');

        return $this->render('test/index.html.twig', [
            'title' => 'Just test',
            'scores' => $scores
        ]);
    }
}
