<?php

namespace Example\ApplicationBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApplicationExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $message = 'Error: ' . $exception->getMessage() . ', code: ' . $exception->getCode();
        
        $response = new Response();
        $response->setContent($message);
        
        if ($exception instanceof HttpExceptionInterface)
        {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }
        else
        {
            $response->setStatusCode(500);
        }
    }
}