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
    private static $cache = [];

    protected function loadResource(string $resource)
    {
        if ([] === self::$cache && \function_exists('opcache_invalidate') && filter_var(\ini_get('opcache.enable'), \FILTER_VALIDATE_BOOLEAN) && (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) || filter_var(\ini_get('opcache.enable_cli'), \FILTER_VALIDATE_BOOLEAN))) {
            self::$cache = null;
        }

        if (null === self::$cache) {
            return require $resource;
        }

        if (isset(self::$cache[$resource])) {
            return self::$cache[$resource];
        }

        return self::$cache[$resource] = require $resource;
    }
}