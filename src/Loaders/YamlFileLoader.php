<?php

namespace hollisho\htranslator\Loaders;

use hollisho\htranslator\Exceptions\InvalidResourceException;
use hollisho\htranslator\Exceptions\ParseException;

class YamlFileLoader extends FileLoader
{

    /**
     * {@inheritdoc}
     */
    protected function loadResource(string $resource)
    {
        if (!function_exists('yaml_parse_file')) {
            return [];
        }

        try {
            $messages = $this->parseFile($resource);
        } catch (ParseException $e) {
            throw new InvalidResourceException(sprintf('The file "%s" does not contain valid YAML: ', $resource).$e->getMessage(), 0, $e);
        }

        if (null !== $messages && !\is_array($messages)) {
            throw new InvalidResourceException(sprintf('Unable to load file "%s".', $resource));
        }

        return $messages ?: [];
    }

    /**
     * @throws ParseException
     */
    private function parseFile($filename)
    {
        if (!is_file($filename)) {
            throw new ParseException(sprintf('File "%s" does not exist.', $filename));
        }

        if (!is_readable($filename)) {
            throw new ParseException(sprintf('File "%s" cannot be read.', $filename));
        }

        return yaml_parse_file($filename);;
    }
}