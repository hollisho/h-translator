<?php

namespace hollisho\htranslator\Catelogues;


interface MessageCatalogueInterface
{
    /**
     * Gets the catalogue locale.
     *
     * @return string
     */
    public function getLocale(): string;

    /**
     * Gets the domains.
     *
     * @return array
     */
    public function getDomains(): array;

    /**
     * Gets the messages within a given domain.
     *
     * If $domain is null, it returns all messages.
     *
     * @param string|null $domain The domain name
     *
     * @return array
     */
    public function all(?string $domain = null): array;

    /**
     * Sets a message translation.
     *
     * @param string $id The message id
     * @param string $translation The messages translation
     * @param string $domain The domain name
     */
    public function set(string $id, string $translation, string $domain = 'messages');

    /**
     * Checks if a message has a translation.
     *
     * @param string $id The message id
     * @param string $domain The domain name
     *
     * @return bool
     */
    public function has(string $id, string $domain = 'messages'): bool;

    /**
     * Checks if a message has a translation (it does not take into account the fallback mechanism).
     *
     * @param string $id The message id
     * @param string $domain The domain name
     *
     * @return bool
     */
    public function defines(string $id, string $domain = 'messages'): bool;

    /**
     * Gets a message translation.
     *
     * @param string $id The message id
     * @param string $domain The domain name
     *
     * @return string
     */
    public function get(string $id, string $domain = 'messages'): string;

    /**
     * Sets translations for a given domain.
     *
     * @param array $messages An array of translations
     * @param string $domain The domain name
     */
    public function replace(array $messages, string $domain = 'messages');

    /**
     * Adds translations for a given domain.
     *
     * @param array $messages An array of translations
     * @param string $domain The domain name
     */
    public function add(array $messages, string $domain = 'messages');

    /**
     * Merges translations from the given Catalogue into the current one.
     *
     * The two catalogues must have the same locale.
     */
    public function addCatalogue(self $catalogue);

}