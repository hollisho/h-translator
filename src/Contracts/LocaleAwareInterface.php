<?php
namespace hollisho\htranslator\Contracts;

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