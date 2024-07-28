<?php

namespace hollisho\htranslator\Catelogues;

use hollisho\htranslator\Contracts\ResourceInterface;

class MessageCatalogue implements MessageCatalogueInterface
{

    public function getLocale()
    {
        // TODO: Implement getLocale() method.
    }

    public function getDomains()
    {
        // TODO: Implement getDomains() method.
    }

    public function all(?string $domain = null)
    {
        // TODO: Implement all() method.
    }

    public function set(string $id, string $translation, string $domain = 'messages')
    {
        // TODO: Implement set() method.
    }

    public function has(string $id, string $domain = 'messages')
    {
        // TODO: Implement has() method.
    }

    public function defines(string $id, string $domain = 'messages')
    {
        // TODO: Implement defines() method.
    }

    public function get(string $id, string $domain = 'messages')
    {
        // TODO: Implement get() method.
    }

    public function replace(array $messages, string $domain = 'messages')
    {
        // TODO: Implement replace() method.
    }

    public function add(array $messages, string $domain = 'messages')
    {
        // TODO: Implement add() method.
    }

    public function addCatalogue(MessageCatalogueInterface $catalogue)
    {
        // TODO: Implement addCatalogue() method.
    }

    public function addFallbackCatalogue(MessageCatalogueInterface $catalogue)
    {
        // TODO: Implement addFallbackCatalogue() method.
    }

    public function getResources()
    {
        // TODO: Implement getResources() method.
    }

    public function addResource(ResourceInterface $resource)
    {
        // TODO: Implement addResource() method.
    }
}