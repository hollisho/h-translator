<?php

namespace hollisho\htranslator\Loaders;

class ArrayLoader implements LoaderInterface
{

    public function load($resource, string $locale, string $domain = 'messages')
    {
        $resource = $this->flatten($resource);
        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($resource, $domain);

        return $catalogue;
    }
}