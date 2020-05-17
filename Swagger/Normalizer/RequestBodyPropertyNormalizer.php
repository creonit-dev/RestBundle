<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Swagger\Spec\RequestBodyProperty;

class RequestBodyPropertyNormalizer extends AbstractNormalizer
{
    /**
     * @param RequestBodyProperty $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [
            'type' => $object->getType(),
            'description' => $object->getDescription(),
        ];

        if ($object->getFormat()) {
            $data['format'] = $object->getFormat();
        }

        return $this->serializer->normalize($data, $format, $context);
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof RequestBodyProperty;
    }
}