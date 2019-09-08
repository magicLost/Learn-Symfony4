<?php

namespace App\EventListener\FosSecurity;


use App\Service\WorkWithTargetPath;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
    private $router;
    private $workWithTargetPath;

    public function __construct(RouterInterface $router, WorkWithTargetPath $workWithTargetPath)
    {

        $this->router = $router;
        $this->workWithTargetPath = $workWithTargetPath;
    }

    function onRegistrationEvent(FormEvent $event){

        /*$url = $this->getTargetPath($event->getRequest()->getSession(), 'main');

        if(!$url){
            $url = $this->router->generate('home');
        }


        $response = new RedirectResponse($url);
        $event->setResponse($response);*/

        $url = $this->workWithTargetPath->getRedirectUri($event->getRequest());

        //$this->removeTargetPath($request->getSession(), $providerKey);

        $response = new RedirectResponse($url);
        $event->setResponse($response);
        //return new RedirectResponse($url);

    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => "onRegistrationEvent",
        ];
    }

}