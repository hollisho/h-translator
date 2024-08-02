<?php

namespace hollisho\htranslator\Resources;

use hollisho\helpers\Arrayable;

/**
 * @author Hollis
 * @desc 数组-数据源
 * Class ArrayResource
 * @package hollisho\htranslator\Resources
 */
class ArrayResource implements ResourceInterface
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

    public function __toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return $this->resource;
    }
}