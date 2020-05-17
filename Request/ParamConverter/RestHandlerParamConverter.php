<?php


namespace Creonit\RestBundle\Request\ParamConverter;


use Creonit\RestBundle\Handler\RestHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

class RestHandlerParamConverter implements ParamConverterInterface
{
    use ContainerAwareTrait;

    public function apply(Request $request, ParamConverter $configuration)
    {
        $handler = $this->container->get(RestHandler::class);
        $handler->setRequest($request);
        $request->attributes->set($configuration->getName(), $handler);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == RestHandler::class;
    }
}