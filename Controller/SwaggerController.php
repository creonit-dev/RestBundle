<?php

namespace Creonit\RestBundle\Controller;

use Creonit\RestBundle\Collector\SpecCollector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SwaggerController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(SpecCollector $collector)
    {
        $spec = $collector->collect();

        return $this->render('@CreonitRest/Swagger/index.html.twig', [
            'spec' => $this->get('serializer')->normalize($spec),
        ]);
    }
}