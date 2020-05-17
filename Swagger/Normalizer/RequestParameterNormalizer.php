<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Annotation\Parameter\RequestParameter;

class RequestParameterNormalizer extends AbstractParameterNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof RequestParameter;
    }
}