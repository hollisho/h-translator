<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Formatters\FormatterInterface;
use hollisho\htranslator\Formatters\MessageFormatter;
use hollisho\objectbuilder\Exceptions\UnknownPropertyException;
use InvalidArgumentException;


class Translator implements TranslatorInterface, LocaleAwareInterface
{

    protected $catalogues = [];

    /**
     * @var LocaleSwitcher
     */
    private $switcher;

    private $formatter;


    /**
     * @param string|null $locale
     * @param FormatterInterface|null $formatter
     * @throws UnknownPropertyException
     */
    public function __construct(string $locale = null, ?FormatterInterface $formatter = null)
    {
        $this->switcher = new LocaleSwitcher();

        if ($locale) {
            $this->setLocale($locale);
        }

        if (null === $formatter) {
            $formatter = new MessageFormatter($this);
        }

        $this->formatter = $formatter;
    }

    /**
     * @param string|null $id
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     * @return string
     * @author Hollis
     * @desc
     */
    public function trans(?string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        if (null === $id || '' === $id) {
            return '';
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        $locale = $catalogue->getLocale();
        while (!$catalogue->defines($id, $domain)) {
            if ($cat = $catalogue->getFallbackCatalogue()) {
                $catalogue = $cat;
                $locale = $catalogue->getLocale();
            } else {
                break;
            }
        }

        return $this->formatter->format($catalogue->get($id, $domain), $locale, $parameters);
    }

    /**
     * Asserts that the locale is valid, throws an Exception if not.
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    protected function assertValidLocale(string $locale): void
    {
        if (!preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
        }
    }

    /**
     * @param string $locale
     * @throws UnknownPropertyException
     * @author Hollis
     * @desc
     */
    public function setLocale(string $locale): void
    {
        $this->assertValidLocale($locale);
        $this->switcher->setLocale($locale);
    }

    /**
     * @return string
     * @author Hollis
     * @desc
     */
    public function getLocale(): string
    {
        return $this->switcher->getLocale();
    }

    /**
     * @throws UnknownPropertyException
     */
    public function reset(): void
    {
        $this->switcher->reset();
    }


    public function getCatalogue(?string $locale = null)
    {
        if (!$locale) {
            $locale = $this->getLocale();
        } else {
            $this->assertValidLocale($locale);
        }

        if (!isset($this->catalogues[$locale])) {
            $this->loadCatalogue($locale);
        }

        return $this->catalogues[$locale];
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogues(): array
    {
        return array_values($this->catalogues);
    }
}


