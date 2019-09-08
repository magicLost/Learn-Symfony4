<?php

namespace App\Controller\Learn_phpunit;


use App\Entity\Learn_phpunit\Enclosure;
use App\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
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
     * @Route("/phpunit", name="phpunit_home")
     */
    public function home()
    {

        $enclosures = $this->entityManager->getRepository(Enclosure::class)->findAll();

        return $this->render("learn_phpunit/main.html.twig", [
            'title' => "Welcome to learn phpUnit home page.",
            'enclosures' => $enclosures
        ]);
    }

    /**
     * @Route("/phpunit/add_dinosaur", name="phpunit_add_dinosaur")
     * @Method({"POST"})
     */
    public function growDinosaur(Request $request, DinosaurFactory $dinosaurFactory)
    {
        $enclosure = $this->entityManager->getRepository(Enclosure::class)
            ->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');

        $dinosaur = $dinosaurFactory->growFromSpecification($specification);

        $dinosaur->setEnclosure($enclosure);

        $enclosure->addDinosaur($dinosaur);

        $this->entityManager->flush();

        $this->addFlash('success', sprintf(
            'Grew a %s in enclosure #%d',
            mb_strtolower($specification),
            $enclosure->getId()
        ));

        return $this->redirectToRoute('home');
    }
}