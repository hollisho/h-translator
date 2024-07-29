<?php
namespace hollisho\htranslator\Formatters;

use hollisho\htranslator\Catelogues\MessageCatalogue;
use hollisho\htranslator\Catelogues\MessageCatalogueInterface;

/**
 * @author Hollis
 * @desc
 * Class MessageFormatter
 * @package hollisho\htranslator\Formatters
 */
class MessageFormatter implements FormatterInterface
{
    private $messageCatalogue;

    public function __construct(MessageCatalogueInterface $messageCatalogue = null)
    {
        $this->messageCatalogue = $messageCatalogue;
    }

    public function format(string $message, string $locale, array $parameters = []): string
    {
        if ($this->messageCatalogue instanceof MessageCatalogueInterface) {
            return $this->messageCatalogue->get($message);
        }

        return strtr($message, $parameters);
    }
}