<?php

namespace App\Controller\SpinColor;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/spin-color", name="spin_color_home")
     */
    public function mainGamePage()
    {
        return $this->render('/spin_color/home.html.twig');
    }
}