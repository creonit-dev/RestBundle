<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Swagger\Spec\Response;

class ResponseNormalizer extends AbstractNormalizer
{
    /**
     * @param Response $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [
            'description' => $object->getDescription(),
            'content' => $this->normalizeContents($object, $format, $context),
        ];

        return $this->serializer->normalize($data, $format, $context);
    }

    /**
     * @param Response $object
     * @param null $format
     * @param array $context
     */
    protected function normalizeContents($object, string $format = null, array $context = [])
    {
        $data = [];

        foreach ($object->getContents() as $content) {
            $data[$content->getContentType()] = $content;
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Response;
    }
}