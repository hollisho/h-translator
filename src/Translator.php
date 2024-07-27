<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Contracts\FormatterInterface;
use hollisho\htranslator\Contracts\LocaleAwareInterface;
use hollisho\htranslator\Contracts\TranslatorInterface;
use hollisho\htranslator\Formatters\MessageFormatter;
use hollisho\htranslator\Objects\LocaleSwitcher;
use hollisho\objectbuilder\Exceptions\BuilderException;
use hollisho\objectbuilder\Exceptions\UnknownPropertyException;
use InvalidArgumentException;


class Translator implements TranslatorInterface, LocaleAwareInterface
{

    /**
     * @var LocaleSwitcher
     */
    private $switcher;

    private $formatter;


    /**
     * @param string|null $locale
     * @param FormatterInterface|null $formatter
     * @throws BuilderException
     * @throws UnknownPropertyException
     */
    public function __construct(?string $locale, ?FormatterInterface $formatter = null)
    {
        $this->switcher = LocaleSwitcher::build();

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
}


