<?php

namespace App\Controller\Score;

use App\Entity\Score\Score;
use App\Entity\Score\ScoreComment;
use App\Form\ScoreFormType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {

        $this->entityManager = $entityManager;
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    /**
     * @Route("/score", name="score")
     */
    public function show_all()
    {
        $form = $this->createForm(ScoreFormType::class);

        //$scores = $this->doctrine->getRepository(Score::class)->findAllActiveOrderByRecentlyActive();
        $scores = $this->doctrine->getRepository(Score::class)->findAll();

        //dump($this->doctrine->getRepository(Score::class));

        return $this->render('score/show.html.twig', [
            'title' => 'Best score table',
            'scores' => $scores,
            'add_form' => $form->createView()
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
    public function add(Request $request)
    {
        if(!$request->isXmlHttpRequest()){

            return $this->json("Bad request");

        }

        if($request->isMethod('GET'))
        {
            //return $this->render();
        }

        try{

            $post = $request->request;

            $score = new Score();
            $score->setScore((int)$post->get('score'));
            $score->setRealName($post->get('real_name'));
            $score->setName($post->get('name'));
            $score->setIsActive($post->get('is_active'));

            $errors = $this->validator->validate($score);

            $count = $errors->count();

            $errors_final = [];

            $name = '';

            if($count > 0){

                for($i = 0; $i < $count; $i++)
                {
                    $error = $errors->get($i);

                    if($name == $error->getPropertyPath())
                        continue;

                    $name = $error->getPropertyPath();

                    $errors_final[$i] = [
                        'name' => $error->getPropertyPath(),
                        'message' => $error->getMessage()
                    ];
                }

                return $this->json(['result' => 'not valid', "errors" => $errors_final]);

            }

            //tells doctrine that you want save this
            $this->entityManager->persist($score);
            //execute
            $this->entityManager->flush();

            return $this->json(['result' => 'success']);
            //return $this->redirectToRoute('score');


        }catch(\Exception $exception){

            return $this->json(['result' => 'exception', "exception" => $exception->getMessage()]);

        }

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
