<?php


namespace Creonit\RestBundle\Swagger\Spec;


class SwaggerSpec
{
    protected $openApiVersion = '3.0.0';
    /** @var ApiInfo  */
    protected $info;

    /** @var ApiServer[] */
    protected $servers = [];

    /** @var Tag[] */
    protected $tags = [];

    /** @var Path[]  */
    protected $paths = [];

    /** @var Component[] */
    protected $components = [];

    public function __construct()
    {
        $this->info = new ApiInfo();
        $this->servers = [new ApiServer()];
    }

    /**
     * @return string
     */
    public function getOpenApiVersion(): string
    {
        return $this->openApiVersion;
    }

    /**
     * @param string $openApiVersion
     *
     * @return $this
     */
    public function setOpenApiVersion(string $openApiVersion)
    {
        $this->openApiVersion = $openApiVersion;
        return $this;
    }

    /**
     * @return ApiInfo
     */
    public function getInfo(): ApiInfo
    {
        return $this->info;
    }

    /**
     * @param ApiInfo $info
     *
     * @return $this
     */
    public function setInfo(ApiInfo $info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return ApiServer[]
     */
    public function getServers(): array
    {
        return $this->servers;
    }

    /**
     * @param ApiServer[] $servers
     *
     * @return $this
     */
    public function setServers(array $servers)
    {
        $this->servers = $servers;
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
     * @return Path[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * @param Path[] $paths
     *
     * @return $this
     */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;
        return $this;
    }

    /**
     * @return Component[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param Component[] $components
     *
     * @return $this
     */
    public function setComponents(array $components)
    {
        $this->components = $components;
        return $this;
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function addServer(ApiServer $server)
    {
        $this->servers[] = $server;
        return $this;
    }

    public function addPath(Path $path)
    {
        $this->paths[] = $path;
        return $this;
    }

    public function addComponent(Component $component)
    {
        $this->components[] = $component;
        return $this;
    }
}