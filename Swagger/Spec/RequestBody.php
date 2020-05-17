<?php


namespace Creonit\RestBundle\Swagger\Spec;


class RequestBody
{
    protected $contentType;

    /** @var RequestBodyProperty[] */
    protected $properties = [];

    /**
     * @return string
     */
    public function getContentType(): string
    {
        if (null === $this->contentType) {
            $this->contentType = $this->hasFile() ? 'multipart/form-data' : 'application/x-www-form-urlencoded';
        }

        return $this->contentType;
    }

    /**
     * @param string $contentType
     *
     * @return $this
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return RequestBodyProperty[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param RequestBodyProperty[] $properties
     *
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @param RequestBodyProperty $property
     *
     * @return $this
     */
    public function addProperty(RequestBodyProperty $property)
    {
        $this->properties[] = $property;
        return $this;
    }

    public function hasFile()
    {
        return !empty(array_filter($this->properties, function (RequestBodyProperty $property) {
            return $property->getFormat() == 'binary';
        }));
    }
}