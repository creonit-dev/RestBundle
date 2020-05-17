<?php


namespace Creonit\RestBundle\Swagger\Spec;


use Creonit\RestBundle\Annotation\Parameter\AbstractParameter;

class Path
{
    protected $path;

    protected $methods = ["get"];
    protected $summary;
    protected $description;

    /** @var AbstractParameter[] */
    protected $parameters = [];

    /** @var Tag[] */
    protected $tags = [];

    /** @var Response[] */
    protected $responses = [];

    /** @var RequestBody|null */
    protected $body;

    public function __construct($path, array $methods)
    {
        $this->path = $path;

        if ($methods) {
            $this->methods = $methods;
        }
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     *
     * @return $this
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
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
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     *
     * @return $this
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @return AbstractParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param AbstractParameter[] $parameters
     *
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function addParameter(AbstractParameter $parameter)
    {
        $this->parameters[] = $parameter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     *
     * @return $this
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @return Response[]
     */
    public function getResponses(): array
    {
        return $this->responses;
    }

    /**
     * @param Response[] $responses
     *
     * @return $this
     */
    public function setResponses(array $responses)
    {
        $this->responses = $responses;
        return $this;
    }

    /**
     * @param Response $response
     *
     * @return $this
     */
    public function addResponse(Response $response)
    {
        $this->responses[] = $response;
        return $this;
    }

    /**
     * @return RequestBody|null
     */
    public function getBody(): ?RequestBody
    {
        return $this->body;
    }

    /**
     * @param RequestBody|null $body
     *
     * @return $this
     */
    public function setBody(?RequestBody $body)
    {
        $this->body = $body;
        return $this;
    }

    protected function createBody()
    {
        return $this->body = new RequestBody();
    }

    public function addBodyProperty(RequestBodyProperty $property)
    {
        if (!$this->body instanceof RequestBody) {
            $this->createBody();
        }

        $this->body->addProperty($property);
    }
}