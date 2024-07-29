<?php

namespace hollisho\htranslator;

/**
 * @author Hollis
 * @desc
 * Interface TranslatorInterface
 * @package hollisho\htranslator\Contracts
 */
interface TranslatorInterface
{

    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null);
}