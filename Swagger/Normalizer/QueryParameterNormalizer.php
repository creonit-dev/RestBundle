<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Creonit\RestBundle\Annotation\Parameter\QueryParameter;

class QueryParameterNormalizer extends AbstractParameterNormalizer
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof QueryParameter;
    }
}