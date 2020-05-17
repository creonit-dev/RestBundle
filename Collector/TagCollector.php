<?php


namespace Creonit\RestBundle\Collector;


use Creonit\RestBundle\Swagger\Spec\Tag;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Routing\Route;
use Creonit\RestBundle\Annotation as Annotation;

class TagCollector implements CollectorInterface
{
    /** @var Reader */
    protected $reader;
    /** @var RouteCollector */
    protected $routeCollector;

    /** @var Tag[] */
    protected $tags;

    public function __construct(Reader $reader, RouteCollector $routeCollector)
    {
        $this->reader = $reader;
        $this->routeCollector = $routeCollector;
    }

    public function collect()
    {
        if (null === $this->tags) {
            $this->tags = $this->collectTags();
        }

        return $this->tags;
    }

    protected function collectTags()
    {
        $result = [];

        foreach ($this->routeCollector->collect() as $route) {
            $tag = $this->makeTagByRoute($route);

            if (!isset($result[$tag->getName()])) {
                $result[$tag->getName()] = $tag;
            }
        }

        return array_values($result);
    }

    public function makeTagByRoute(Route $route)
    {
        $tag = new Tag();
        $reflectionClass = $this->getReflectionClass($route);

        $this->readAnnotations($reflectionClass, $tag);

        return $tag;
    }

    protected function readAnnotations(\ReflectionClass $class, Tag $tag)
    {
        foreach ($this->reader->getClassAnnotations($class) as $annotation) {
            if ($annotation instanceof Annotation\Tag) {
                $tag
                    ->setName($annotation->getName())
                    ->setDescription($annotation->getDescription());
            }
        }

        if (!$tag->getName()) {
            $tag->setName($this->makeNameByClass($class));
        }

        return $tag;
    }

    protected function makeNameByClass(\ReflectionClass $class)
    {
        $className = $class->getName();
        $explodedName = explode('\\', $className);

        return preg_replace('/Controller$/', '', end($explodedName));
    }

    protected function getReflectionClass(Route $route)
    {
        list($class, $name) = explode('::', $route->getDefault('_controller'));

        return new \ReflectionClass($class);
    }
}