<?php

namespace Creonit\RestBundle\Handler;

use Symfony\Component\HttpFoundation\ParameterBag;

class RestData
{
    const FORMAT_JSON = 'json';

    protected $data;
    protected $format = self::FORMAT_JSON;

    public $context;

    public function __construct()
    {
        $this->context = new ParameterBag();
    }

    public function set($data)
    {
        $this->data = $data;
        return $this;
    }

    public function get()
    {
        return $this->data;
    }

    /**
     * @param string $format
     *
     * @return RestData
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string[] $groups
     *
     * @return $this
     */
    public function setGroups(array $groups)
    {
        $this->context->set('groups', $groups);
        return $this;
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    public function addGroup(string $group)
    {
        $groups = $this->context->get('groups');
        $groups[] = $group;

        return $this->setGroups($groups);
    }

}