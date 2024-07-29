<?php
namespace hollisho\htranslator\Locale;

/**
 * @author Hollis
 * @desc
 * Interface LocaleAwareInterface
 * @package hollisho\htranslator\Contracts
 */
interface LocaleAwareInterface
{
    public function setLocale(string $locale): void;

    public function getLocale(): string;

    public function reset(): void;
}