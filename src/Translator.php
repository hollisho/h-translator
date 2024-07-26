<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Contracts\FormatterInterface;
use hollisho\htranslator\Contracts\TranslatorInterface;
use hollisho\htranslator\Formatters\MessageFormatter;
use hollisho\htranslator\Objects\LocaleSwitcher;
use hollisho\objectbuilder\Exceptions\BuilderException;
use hollisho\objectbuilder\Exceptions\UnknownPropertyException;
use InvalidArgumentException;


class Translator implements TranslatorInterface
{

    /**
     * @var LocaleSwitcher
     */
    private $switcher;

    private $formatter;


    /**
     * @param string $locale
     * @param FormatterInterface|null $formatter
     * @throws BuilderException
     */
    public function __construct(string $locale, ?FormatterInterface $formatter = null)
    {
        $this->switcher = LocaleSwitcher::build();

        $this->setLocale($locale);

        if (null === $formatter) {
            $formatter = new MessageFormatter();
        }

        $this->formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function trans(?string $id, array $parameters = [], ?string $domain = null, ?string $locale = null)
    {
        if (null === $id || '' === $id) {
            return '';
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        $catalogue = $this->getCatalogue($locale);
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
     * @throws UnknownPropertyException
     */
    public function setLocale(string $locale): void
    {
        $this->assertValidLocale($locale);
        $this->switcher->setLocale($locale);
    }

    public function getLocale(): string
    {
        return $this->switcher->getLocale();
    }
}


