<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Annotation\Parameter\PathParameter;

class PathParameterNormalizer extends AbstractParameterNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof PathParameter;
    }
}