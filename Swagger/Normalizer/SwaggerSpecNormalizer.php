<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Swagger\Spec\Path;
use Creonit\RestBundle\Swagger\Spec\SwaggerSpec;

class SwaggerSpecNormalizer extends AbstractNormalizer
{
    protected $spec = [];

    public function __construct($spec)
    {
        $this->spec = $spec;
    }

    /**
     * @param SwaggerSpec $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [
            'openapi' => $object->getOpenApiVersion(),
            'info' => $object->getInfo(),
            'servers' => $object->getServers(),
            'tags' => $object->getTags(),
            'paths' => $this->normalizePaths($object, $format, $context),
        ];

        return array_merge_recursive(
            $this->serializer->normalize($data, $format, $context),
            $this->spec
        );
    }

    /**
     * @param SwaggerSpec $object
     * @param null $format
     * @param array $context
     */
    protected function normalizePaths($object, string $format = null, array $context = [])
    {
        $result = [];

        $paths = $object->getPaths();
        $urls = $this->getUrls($paths);

        foreach ($urls as $url) {
            $urlsParams = [];

            $urlPaths = array_filter($paths, function (Path $path) use ($url) {
                return $path->getPath() == $url;
            });

            foreach ($urlPaths as $path) {
                foreach ($path->getMethods() as $method) {
                    $urlsParams[strtolower($method)] = $path;
                }
            }

            $result[$url] = $urlsParams;
        }

        return $result;
    }

    /**
     * @param Path[] $paths
     *
     * @return array
     */
    protected function getUrls(array $paths)
    {
        $urls = array_map(function (Path $path) {
            return $path->getPath();
        }, $paths);

        return array_unique($urls);
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof SwaggerSpec;
    }
}
