<?php

namespace hollisho\htranslator\Contracts;

interface TranslatorInterface
{
    public function setLocale(string $locale): void;

    public function getLocale(): string;

    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null);
}