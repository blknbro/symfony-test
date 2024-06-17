<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserAgentSubscriber implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }
    
    
    
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info(sprintf('The User agent is %s',$userAgent));
    }

    public static function getSubscribedEvents()
    {

        return[
            RequestEvent::class => 'onKernelRequest'
        ];

    }


}