<?php

namespace hollisho\htranslator\Loaders;

use hollisho\htranslator\Catelogues\MessageCatalogue;

/**
 * @author Hollis
 * @desc 数组类型-数据加载器
 * Class ArrayLoader
 * @package hollisho\htranslator\Loaders
 */
class ArrayLoader implements LoaderInterface
{

    public function load($resource, string $locale, string $domain = 'messages'): MessageCatalogue
    {
        $resource = $this->flatten($resource);
        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($resource, $domain);

        return $catalogue;
    }

    /**
     * Flattens an nested array of translations.
     *
     * The scheme used is:
     *   'key' => ['key2' => ['key3' => 'value']]
     * Becomes:
     *   'key.key2.key3' => 'value'
     */
    private function flatten(array $messages): array
    {
        $result = [];
        foreach ($messages as $key => $value) {
            if (\is_array($value)) {
                foreach ($this->flatten($value) as $k => $v) {
                    if (null !== $v) {
                        $result[$key.'.'.$k] = $v;
                    }
                }
            } elseif (null !== $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}