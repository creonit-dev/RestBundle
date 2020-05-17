<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Annotation\Parameter\AbstractParameter;

abstract class AbstractParameterNormalizer extends AbstractNormalizer
{
    /**
     * @param AbstractParameter $object
     * @param null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [
            'name' => $object->name,
            'in' => $object->in,
            'description' => $object->description,
            'required' => $object->required,
            'style' => $object->style,
            'explode' => $object->explode,
            'schema' => $this->normalizeSchema($object, $format, $context),
        ];

        return $this->serializer->normalize($data, $format, $context);
    }

    /**
     * @param AbstractParameter $object
     * @param null $format
     * @param array $context
     */
    protected function normalizeSchema($object, string $format = null, array $context = [])
    {
        $schema = [
            'type' => $object->type,
        ];

        if ($object->format) {
            $schema['format'] = $object->format;
        }

        if ($object->type == 'array') {
            $schema['items'] = [
                'type' => $object->itemsType,
            ];
        }

        return $schema;
    }
}