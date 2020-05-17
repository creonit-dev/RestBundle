<?php

namespace Creonit\RestBundle\Exception;

use Creonit\RestBundle\Handler\RestError;

class RestErrorException extends \Exception
{
    /** @var RestError */
    protected $restError;

    /**
     * @return RestError
     */
    public function getRestError(): RestError
    {
        return $this->restError;
    }

    /**
     * @param RestError $restError
     *
     * @return $this
     */
    public function setRestError(RestError $restError)
    {
        $this->restError = $restError;
        return $this;
    }
}