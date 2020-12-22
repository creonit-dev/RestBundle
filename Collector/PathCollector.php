<?php


namespace Creonit\RestBundle\Collector;

use Creonit\RestBundle\Annotation\Parameter\AbstractParameter;
use Creonit\RestBundle\Annotation\Parameter\RequestParameter;
use Creonit\RestBundle\Swagger\Spec\Path;
use Creonit\RestBundle\Swagger\Spec\RequestBodyProperty;
use Creonit\RestBundle\Swagger\Spec\Response;
use Creonit\RestBundle\Swagger\Spec\ResponseContent;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Routing\Route;

class PathCollector implements CollectorInterface
{
    /** @var Reader */
    protected $reader;

    /** @var RouteCollector */
    protected $routeCollector;

    /** @var TagCollector */
    protected $tagCollector;

    public function __construct(Reader $reader, RouteCollector $routeCollector, TagCollector $tagCollector)
    {
        $this->reader = $reader;
        $this->routeCollector = $routeCollector;
        $this->tagCollector = $tagCollector;
    }

    public function collect()
    {
        $result = [];
        foreach ($this->routeCollector->collect() as $route) {
            $result[] = $this->makePath($route);
        }

        return $result;
    }

    protected function getReflectionMethod(Route $route)
    {
        list($class, $name) = explode('::', $route->getDefault('_controller'));

        return new \ReflectionMethod($class, $name);
    }

    protected function makePath(Route $route)
    {
        $method = $this->getReflectionMethod($route);
        $path = new Path($route->getPath(), $route->getMethods());

        if ($tag = $this->tagCollector->makeTagByRoute($route)) {
            $path->addTag($tag);
        }

        $this->readDocComment($method, $path);
        $this->readMethodAnnotations($method, $path);
        $this->addResponses($path);

        return $path;
    }

    protected function readDocComment(\ReflectionMethod $method, Path $path)
    {
        $summary = '';
        $description = '';

        if ($docComment = $method->getDocComment()) {
            CollectorHelper::parseDocComment($docComment, $summary, $description);
        }

        $path
            ->setSummary($summary)
            ->setDescription($description);

        return $path;
    }

    protected function readMethodAnnotations(\ReflectionMethod $method, Path $path)
    {
        $annotations = $this->reader->getMethodAnnotations($method);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof RequestParameter) {
                $bodyProperty = new RequestBodyProperty();
                $bodyProperty
                    ->setName($annotation->name)
                    ->setType($annotation->type)
                    ->setDescription($annotation->description)
                    ->setFormat($annotation->format)
                    ->setExplode($annotation->explode);

                $path->addBodyProperty($bodyProperty);

            } elseif ($annotation instanceof AbstractParameter) {
                $path->addParameter($annotation);
            }
        }

        return $path;
    }

    protected function addResponses(Path $path)
    {
        $this->addSuccessResponse($path);
        $this->addErrorResponse($path);

        return $path;
    }

    protected function addSuccessResponse(Path $path)
    {
        $successResponseContent = new ResponseContent();

        $successResponse = new Response();
        $successResponse
            ->addContent($successResponseContent)
            ->setCode(200);

        $path->addResponse($successResponse);

        return $path;
    }

    protected function addErrorResponse(Path $path)
    {
        $errorResponseContent = new ResponseContent();

        $errorResponse = new Response();
        $errorResponse
            ->addContent($errorResponseContent)
            ->setCode(400);

        $path->addResponse($errorResponse);

        return $path;
    }
}
