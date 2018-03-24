<?php

namespace App\Controller\Score;

use App\Entity\Score\Score;
use App\Entity\Score\ScoreComment;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScoreController extends Controller
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
     * @Route("/score", name="score")
     */
    public function show_all()
    {
        $scores = $this->doctrine->getRepository(Score::class)->findAllActiveOrderByRecentlyActive();

        //dump($this->doctrine->getRepository(Score::class));

        return $this->render('score/show.html.twig', [
            'title' => 'Best score table',
            'scores' => $scores
        ]);
    }

    /**
     * @Route("/score/show/{id}", name="score_show_by_id", requirements={"id"="\d+"})
     */
    public function show_by_id($id)
    {
        $score_by_id = $this->doctrine->getRepository(Score::class)->findOneBy(['id' => $id]);

        //dump($scorers);die;
        if(!$score_by_id){
            throw $this->createNotFoundException('No scorer found');
        }

        $recentComments = $this->doctrine->getRepository(ScoreComment::class)->findAllRecentCommentsForScorer($score_by_id);

        dump($recentComments);

        return $this->render('score/show_by_id.html.twig', [
            'title' => 'One of ours scorers',
            'score' => $score_by_id
        ]);
    }

    /**
     * @Route("/score/add", name="score_add")
     */
    public function add()
    {
        $score = new Score();
        $score->setScore(rand(11, 2300));
        $score->setName("Robot".rand(1, 100));

        //tells doctrine that you want save this
        $this->entityManager->persist($score);
        //execute
        $this->entityManager->flush();

        return $this->render('score/add.html.twig', [
            'title' => "Add your score information",
            'score' => $score
        ]);
    }

    /**
     * @Route("/score/{name}/get_comments", name="score_getcomments", methods={"POST"})
     */
    public function getComments(Score $score)
    {
        //ajax-request from score_show_by_id

        $comments = [];

        $comments_arrayObj = $score->getComments();

        foreach($comments_arrayObj as $comment){
            //dump($comment);
            $comments[] = [
                'id' => $comment->getId(),
                'name' => $comment->getName(),
                'comment' => $comment->getComment(),
                'date' => $comment->getCreatedAt()->format('M d, Y')
            ];
        }


        return $this->json($comments);
    }
}
