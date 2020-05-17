<?php


namespace Creonit\RestBundle\Collector;


use Creonit\RestBundle\Swagger\Spec\SwaggerSpec;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SpecCollector implements CollectorInterface
{
    /** @var Reader */
    protected $reader;

    /** @var PathCollector */
    protected $pathCollector;

    /** @var TagCollector */
    protected $tagCollector;

    public function __construct(Reader $reader, ContainerInterface $container)
    {
        $this->reader = $reader;
        $this->pathCollector = $container->get(PathCollector::class);
        $this->tagCollector = $container->get(TagCollector::class);
    }

    public function collect()
    {
        $spec = new SwaggerSpec();
        $spec
            ->setTags($this->tagCollector->collect())
            ->setPaths($this->pathCollector->collect());

        return $spec;
    }
}