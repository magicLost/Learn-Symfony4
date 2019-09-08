<?php

namespace App\Controller;


use App\Service\WorkWithLocale;
use App\Service\WorkWithLocaleException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ChangeLocaleController extends Controller
{
    private $workWithLocale;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(WorkWithLocale $workWithLocale, RouterInterface $router)
    {
        $this->workWithLocale = $workWithLocale;
        $this->router = $router;
    }

    /**
     * @Route("/change_locale", name="change_locale", methods={"post"})
     */
    public function change(Request $request)
    {

        try{

            //dump($this->workWithLocale->getLocale($request));

            $this->workWithLocale->changeLocale($request);

            //dump($this->workWithLocale->getLocale($request));

            $this->workWithLocale->setLocaleToRequest($request, $this->workWithLocale->getLocale($request));

            //dump($request->getLocale());

            //return $this->redirectToRoute(($this->router->match($_SERVER["HTTP_REFERER"])) ?? $this->router->generate('home'));
            return new RedirectResponse(($_SERVER['HTTP_REFERER']) ?? $this->router->generate('home'));

        }catch (WorkWithLocaleException $exception){

            //TODO logging
            return new RedirectResponse(($_SERVER['HTTP_REFERER']) ?? $this->router->generate('home'));

        }

    }

}