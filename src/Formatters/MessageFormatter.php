<?php
namespace hollisho\htranslator\Formatters;

use hollisho\htranslator\Translator;
use hollisho\htranslator\TranslatorInterface;

/**
 * @author Hollis
 * @desc
 * Class MessageFormatter
 * @package hollisho\htranslator\Formatters
 */
class MessageFormatter implements FormatterInterface
{

    private $translator;

    /**
     * @param TranslatorInterface|null $translator
     */
    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator ?? new Translator();
    }


    public function format(string $message, string $locale, array $parameters = []): string
    {
        return $this->translator->trans($message, $parameters, null, $locale);
    }
}