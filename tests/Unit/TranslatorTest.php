<?php
namespace hollisho\htranslator;

use hollisho\htranslator\Objects\LocaleSwitcher;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{

    public function testLocale()
    {
        /** @var LocaleSwitcher $locale */
        $locale = LocaleSwitcher::build();
        $this->assertTrue($locale->getLocale() === $locale->getDefaultLocale());
    }

    public function testTranslator()
    {
        $translator = new Translator();

        $this->assertTrue(true);
    }

}