<?php

namespace App\Controller\Manager;

use App\Test\Test;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/manager", name="manager_home")
     */
    public function index()
    {
        return $this->render('manager/index.html.twig', [
            'title' => 'Management'
        ]);
    }
}