<?php

namespace hollisho\htranslator\Loaders;

/**
 * @author Hollis
 * @desc PHP配置-数据加载器
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