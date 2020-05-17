<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Swagger\Spec\ResponseContent;

class ResponseContentNormalizer extends AbstractNormalizer
{
    /**
     * @param ResponseContent $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [
            'schema' => [
                'type' => $object->getType(),
                'items' => $object->getItems(),
            ]
        ];

        return $this->serializer->normalize($data, $format, $context);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ResponseContent;
    }
}