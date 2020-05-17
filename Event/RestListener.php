<?php

namespace Creonit\RestBundle\Event;

use Creonit\RestBundle\Exception\RestErrorException;
use Creonit\RestBundle\Handler\RestError;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RestListener
{

    /** @var  ContainerInterface */
    protected $container;
    /** @var LoggerInterface  */
    protected $logger;

    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
    }

    public function onKernelException(ExceptionEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if (!preg_match('#^/api/#', $event->getRequest()->getPathInfo())) {
            return;
        }

        if ($this->container->get('request_stack')->getCurrentRequest() !== $event->getRequest()) {
            return;
        }

        $exception = $event->getThrowable();

        if ($exception instanceof RestErrorException) {
            $error = $exception->getRestError();

        } else {
            $error = new RestError();
            $error->setMessage(
                $this->container->getParameter('kernel.debug')
                    ? $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine() . ' | ' . $exception->getTraceAsString()
                    : 'Системная ошибка'
            );
            $error->setCode($exception->getCode());
            $error->setStatus(500);

            $this->logger->critical($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine() . ' | ' . $exception->getTraceAsString());
        }

        $event->setResponse(new JsonResponse($error->dump(), $error->getStatus()));
    }

}