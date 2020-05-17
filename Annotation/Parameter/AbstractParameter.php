<?php


namespace Creonit\RestBundle\Annotation\Parameter;


use Creonit\RestBundle\Swagger\Spec\SwaggerParameterInterface;

abstract class AbstractParameter
{
    public $name;
    public $description;
    public $type;
    public $format;
    public $required;
    public $in;
    public $itemsType;
    public $style;
    public $explode;

    public function __construct($data)
    {
        $this->name = $data['value'];
        $this->in = isset($data['in']) ? $data['in'] : false;
        $this->required = isset($data['required']) ? (bool)$data['required'] : false;
        $this->description = isset($data['description']) ? $data['description'] : '';
        $this->type = isset($data['type']) ? $data['type'] : 'string';
        $this->format = isset($data['format']) ? $data['format'] : '';
        $this->itemsType = isset($data['itemsType']) ? $data['itemsType'] : 'string';
        $this->style = isset($data['style']) ? $data['style'] : 'form';
        $this->explode = isset($data['explode']) ? $data['explode'] : true;
    }
}