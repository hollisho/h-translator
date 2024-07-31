<?php

namespace hollisho\htranslator\Formatters;

/**
 * @author Hollis
 * @desc
 * Interface FormatterInterface
 * @package hollisho\htranslator\Contracts
 */
interface FormatterInterface
{
    /**
     * Formats a localized message pattern with given arguments.
     *
     * @param mixed $message    The message
     * @param string $locale     The message locale
     * @param array  $parameters An array of parameters for the message
     */
    public function format($message, string $locale, array $parameters = []): string;
}