<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Swagger\Spec\RequestBody;

class RequestBodyNormalizer extends AbstractNormalizer
{
    /**
     * @param RequestBody $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $properties = [];
        $encoding = [];

        foreach ($object->getProperties() as $property) {
            $properties[$property->getName()] = $property;

            if ($property->getExplode()) {
                $encoding[$property->getName()] = [
                    'explode' => true
                ];
            }
        }

        $data = [
            'schema' => [
                'type' => 'object',
                'properties' => $properties,
            ],
            'encoding' => $encoding
        ];

        return $this->serializer->normalize($data, $format, $context);
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof RequestBody;
    }
}
