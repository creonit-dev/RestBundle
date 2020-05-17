<?php


namespace Creonit\RestBundle\Swagger\Spec;


class Response
{
    protected $code;
    protected $description;

    /** @var ResponseContent[] */
    protected $contents = [];

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ResponseContent[]
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * @param ResponseContent[] $contents
     *
     * @return $this
     */
    public function setContents(array $contents)
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @param ResponseContent $content
     *
     * @return $this
     */
    public function addContent(ResponseContent $content)
    {
        $this->contents[] = $content;
        return $this;
    }
}