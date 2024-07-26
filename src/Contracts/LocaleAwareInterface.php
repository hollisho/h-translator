<?php
namespace hollisho\htranslator\Contracts;

interface LocaleAwareInterface
{
    public function setLocale(string $locale): void;

    public function getLocale(): string;

    public function runWithLocale(string $locale, callable $callback);

    public function reset(): void;
}