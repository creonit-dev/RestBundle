<?php


namespace Creonit\RestBundle\Swagger\Normalizer;


use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractNormalizer implements NormalizerInterface
{
    /** @var Serializer */
    protected $serializer;

    /**
     * @param Serializer $serializer
     *
     * @return $this
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
        return $this;
    }
}