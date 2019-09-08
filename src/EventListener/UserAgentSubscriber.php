<?php

namespace App\EventListener;


use App\Service\UnityAuthHeaders;
use App\Service\WorkWithLocale;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserAgentSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $container;
    private $workWithLocale;
    private $authHeaders;

    public function __construct(
        LoggerInterface $logger,
        ContainerInterface $container,
        WorkWithLocale $workWithLocale,
        UnityAuthHeaders $authHeaders
    )
    {
        $this->logger = $logger;
        $this->container = $container;
        $this->workWithLocale = $workWithLocale;
        $this->authHeaders = $authHeaders;
    }

    public function onKernelRequest(GetResponseEvent $event){

        $this->logger->info("RRREAAAAWWWW!!!!!!!!");

        $request = $event->getRequest();
        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info('The user agent is: '.$userAgent);

        //locale
        $locale = $this->workWithLocale->getLocale($request);
        $this->workWithLocale->setLocaleToRequest($request, $locale);



        //dump($request->getLocale());

        //$request->attributes->set("_locale", 'ru');

        //1
        //if(rand(0, 100) > 50){
            //$response = new Response('Come back later');
            //$event->setResponse($response);
        //}

        //2
        //передать параметр в контроллер
        //in controller -> indexAction($locale){}

        //3
        //RouterListener проверяет наличие _controller
        //и если он есть то не делает роутинг
        /*$request->attributes->set('_controller', function($id){
            //id - parametr in router in controller
            return new Response("Hello world ".$id);
        });*/
    }

    public  function onKernelResponse(FilterResponseEvent $event)
    {
        //headers for auth on game page
        $this->authHeaders->onResponse($event->getRequest(), $event->getResponse());
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 18]
            ],
            KernelEvents::RESPONSE => 'onKernelResponse'

            //'kernel.request' => 'onKernelRequest',
            //'kernel.response' => 'onKernelResponse',
        ];
    }

}