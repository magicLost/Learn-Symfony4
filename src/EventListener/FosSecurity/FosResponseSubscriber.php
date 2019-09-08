<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 31.05.2018
 * Time: 22:41
 */

namespace App\EventListener\FosSecurity;


use App\Service\WorkWithTargetPath;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;

class FosResponseSubscriber implements EventSubscriberInterface
{
    private $workWithTargetPath;
    private $router;

    public function __construct(WorkWithTargetPath $workWithTargetPath, RouterInterface $router)
    {
        $this->workWithTargetPath = $workWithTargetPath;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if($event->getRequest()->isXmlHttpRequest())
            return;

        $uri = $event->getRequest()->getRequestUri();

        //if user go to not fos_security addresses we do nothing
        if($this->workWithTargetPath->isGoodUri($uri)){
            //dump("good uri");
            return;
        }
        //dump($event->getRequest()->getRequestUri());
        //dump($this->router->generate("fos_user_security_login"));

        $referer = ($_SERVER['HTTP_REFERER']) ?? '';
        $this->workWithTargetPath->saveReferer($referer, $event->getRequest());
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        dump($event->getRequest()->getRequestUri());
        dump($event->getRequest()->getPathInfo());
        $referer = ($_SERVER['HTTP_REFERER']) ?? '';
        $this->workWithTargetPath->saveReferer($referer, $event->getRequest());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'OnKernelRequest',
            //'kernel.response' => 'OnKernelResponse'
        ];
    }

}