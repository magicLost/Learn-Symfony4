<?php

namespace App\Controller;


use App\Entity\Admin\User;
use App\Entity\Score;
use App\Form\ScoreFormType;
use App\Service\EnclosureBuilderService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;


class TestController extends Controller
{

    private $entityManager;
    private $enclosureBuilderService;
    private $mailer;
    private $translator;
    private $authorizationChecker;
    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(
        EntityManagerInterface $entityManager,
        EnclosureBuilderService $enclosureBuilderService,
        \Swift_Mailer $mailer,
        TranslatorInterface $translator,
        AuthorizationCheckerInterface $authorizationChecker,
        LoggerInterface $logger
    )
    {

        $this->entityManager = $entityManager;
        $this->enclosureBuilderService = $enclosureBuilderService;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->authorizationChecker = $authorizationChecker;
        $this->logger = $logger;
    }

    /**
     * @Route("/{_locale}/test", name="test_index", requirements={"en|ru"})
     */
    public function index(Request $request)
    {

        //dump($request->getSession());

        if($request->isMethod("POST") && $request->isXmlHttpRequest()){

            $result = ($this->authorizationChecker->isGranted('ROLE_USER')) ? 'log in' : 'denied';

            $headers = [];

            foreach($request->headers as $key=>$val){

                $headers[$key] = $val;

            }

            $this->logger->error("Ajax_headers", $headers);

            return $this->json($headers);

        }

        $translated = $this->translator->trans("Hello.people");

        $result = 'hello';

        return $this->render('test/index.html.twig', [
            'title' => 'Test',
            'result' => $result
        ]);


        /*$result = ($this->authorizationChecker->isGranted('ROLE_USER')) ? 'log in' : 'denied';


        $headers = ['result' => $result];

        foreach($request->headers as $key=>$val){

            $headers[$key] = $val;

        }

        //$this->logger->error("Ajax_headers", $headers);

        return $this->json($headers);*/

    }

    /*public function index()
    {
        //dump($this->mailer);die;

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    array('name' => "Diana")
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )

        ;

        $result = $this->mailer->send($message);

        return $this->render('test/index.html.twig', [
            'title' => 'Test',
            'result' => $result
        ]);
    }*/
}
