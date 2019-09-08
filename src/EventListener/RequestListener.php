<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        $filter = $this->entityManager->getFilters()->enable('fortune_cookie_discontinued');
        $filter->setParameter('discontinued', false);
    }
}