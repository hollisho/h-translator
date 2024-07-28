<?php
namespace hollisho\htranslator;

use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{

    public function testLocale()
    {
        $locale = new LocaleSwitcher();
        $this->assertTrue($locale->getLocale() === $locale->getDefaultLocale());
    }

    public function testTranslator()
    {
        $translator = new Translator();
        $translator->trans("Hollis");

        $this->assertTrue(true);
    }

}