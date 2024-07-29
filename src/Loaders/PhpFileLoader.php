<?php

namespace hollisho\htranslator\Loaders;

use hollisho\htranslator\Exceptions\InvalidResourceException;

/**
 * @author Hollis
 * @desc
 * Class PhpFileLoader
 * @package hollisho\htranslator\Loaders
 */
class PhpFileLoader extends FileLoader
{

    protected function loadResource(string $resource)
    {
        return require $resource;
    }
}