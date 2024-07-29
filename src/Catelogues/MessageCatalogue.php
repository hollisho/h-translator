<?php

namespace hollisho\htranslator\Catelogues;

use hollisho\htranslator\Resources\ResourceInterface;
use LogicException;

/**
 * @author Hollis
 * @desc
 * Class MessageCatalogue
 * @package hollisho\htranslator\Catelogues
 */
class MessageCatalogue implements MessageCatalogueInterface
{
    /**
     * @var array
     */
    private $messages = [];

    /**
     * @var array
     */
    private $resources = [];

    /**
     * @var string
     */
    private $locale;

    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return array
     * @author Hollis
     * @desc 遍历获取所有domain
     */
    public function getDomains(): array
    {
        $domains = [];

        foreach ($this->messages as $domain => $messages) {
            $domains[$domain] = $domain;
        }

        return array_values($domains);
    }

    public function __construct(string $locale, array $messages = [])
    {
        $this->locale = $locale;
        $this->messages = $messages;
    }

    public function all(?string $domain = null): array
    {
        $allMessages = [];

        foreach ($this->messages as $domain => $messages) {
            $allMessages[$domain] = ($allMessages[$domain] ?? []) + $messages;
        }

        return $allMessages;
    }

    public function set(string $id, string $translation, string $domain = 'messages')
    {
        $this->add([$id => $translation], $domain);
    }

    public function has(string $id, string $domain = 'messages'): bool
    {
        if (isset($this->messages[$domain][$id])) {
            return true;
        }

        return false;
    }

    public function defines(string $id, string $domain = 'messages'): bool
    {
        return isset($this->messages[$domain][$id]);
    }

    public function get(string $id, string $domain = 'messages')
    {
        if (isset($this->messages[$domain][$id])) {
            return $this->messages[$domain][$id];
        }

        return $id;
    }

    public function replace(array $messages, string $domain = 'messages')
    {
        unset($this->messages[$domain]);

        $this->add($messages, $domain);
    }

    public function add(array $messages, string $domain = 'messages')
    {
        foreach ($messages as $id => $message) {
            $this->messages[$domain][$id] = $message;
        }
    }

    /**
     * @param MessageCatalogueInterface $catalogue
     * @return void
     * @author Hollis
     * @desc 追加catalogue
     */
    public function addCatalogue(MessageCatalogueInterface $catalogue)
    {
        if ($catalogue->getLocale() !== $this->locale) {
            throw new LogicException(sprintf('Cannot add a catalogue for locale "%s" as the current locale for this catalogue is "%s".', $catalogue->getLocale(), $this->locale));
        }

        foreach ($catalogue->all() as $domain => $messages) {
            $this->add($messages, $domain);
        }

        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }

    }

    public function getResources(): array
    {
        return array_values($this->resources);
    }

    public function addResource(ResourceInterface $resource)
    {
        $this->resources[$resource->__toString()] = $resource;
    }
}