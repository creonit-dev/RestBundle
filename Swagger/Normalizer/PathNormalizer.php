<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Swagger\Spec\Path;
use Creonit\RestBundle\Swagger\Spec\Tag;

class PathNormalizer extends AbstractNormalizer
{
    /**
     * @param Path $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [
            'tags' => array_map(function (Tag $tag) {
                return $tag->getName();
            }, $object->getTags()),
            'summary' => $object->getSummary(),
            'description' => $object->getDescription(),
            'parameters' => $object->getParameters(),
            'responses' => $this->normalizeResponses($object, $format, $context)
        ];

        if ($object->getBody()) {
            $data['requestBody'] = $this->normalizeBody($object, $format, $context);
        }

        return $this->serializer->normalize($data, $format, $context);
    }

    /**
     * @param Path $object
     * @param null $format
     * @param array $context
     */
    protected function normalizeResponses($object, string $format = null, array $context = [])
    {
        $data = [];
        foreach ($object->getResponses() as $response) {
            $data[$response->getCode()] = $response;
        }

        return $data;
    }

    /**
     * @param Path $object
     * @param null $format
     * @param array $context
     */
    protected function normalizeBody($object, $format = null, array $context = [])
    {
        $body = $object->getBody();

        return [
            'content' => [
                $body->getContentType() => $body
            ]
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Path;
    }
}