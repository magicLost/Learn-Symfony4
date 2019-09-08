<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 19.05.2018
 * Time: 23:23
 */

namespace App\EventListener\FosSecurity;


use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Hautelook\AliceBundle\Functional\TestBundle\Entity\Inte;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

//FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            //SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',


class LoginAuthenticationHandler implements EventSubscriberInterface
{
    use TargetPathTrait;

    private $router;

    public function __construct(RouterInterface $router)
    {

        $this->router = $router;
    }

    public function onFosRegistrationInitialize($event){
        //dump($event);
        //dump($_SERVER['HTTP_REFERER']);
    }

    public function onFOSLoginEvent(UserEvent $event){
        //dump($event);
    }

    public function onSymfonyLoginEvent(InteractiveLoginEvent $event){
        //dump($event);
    }

    public static function getSubscribedEvents()
    {
        return [
            //FOSUserEvents::REGISTRATION_INITIALIZE => "onFosRegistrationInitialize"
            //FOSUserEvents::SECURITY_IMPLICIT_LOGIN => "onFOSLoginEvent",
            //SecurityEvents::INTERACTIVE_LOGIN => 'onSymfonyLoginEvent'
        ];
    }

}