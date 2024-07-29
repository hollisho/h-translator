<?php

namespace hollisho\htranslator\Resources;

use hollisho\helpers\Arrayable;

class ArrayResource implements ResourceInterface, Arrayable
{
    /**
     * @var string|false
     */
    private $resource;

    public function __construct(array $resource)
    {
        $this->resource = $resource;
    }


    public function __toString()
    {
        return md5(json_encode($this->resource));
    }

    public function fields()
    {
        // TODO: Implement fields() method.
    }

    public function extraFields()
    {
        // TODO: Implement extraFields() method.
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return $this->resource;
    }
}