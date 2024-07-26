<?php
namespace hollisho\htranslator\Formatters;

use hollisho\htranslator\Contracts\FormatterInterface;
use hollisho\htranslator\Contracts\TranslatorInterface;

class MessageFormatter implements FormatterInterface
{

    private $translator;

    /**
     * @param TranslatorInterface|null $translator
     */
    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator ?? new IdentityTranslator();
    }


    public function format(string $message, string $locale, array $parameters = []): string
    {
        return $this->translator->trans($message, $parameters, null, $locale);
    }
}