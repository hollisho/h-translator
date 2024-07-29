<?php
namespace hollisho\htranslator;

use hollisho\htranslator\Loaders\PhpFileLoader;
use hollisho\htranslator\Locale\LocaleManager;
use hollisho\objectbuilder\Exceptions\BuilderException;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{

    public function testLocale()
    {
        $locale = new LocaleManager();
        $this->assertTrue($locale->getLocale() === $locale->getDefaultLocale());
    }

    /**
     * @throws BuilderException
     */
    public function testTranslator()
    {
        $translator = new Translator();

        $phpFileLoader = new PhpFileLoader();
        $translator->addLoader('phpFile', $phpFileLoader);
        $translator->addResource('phpFile', dirname(__DIR__) . "/Files/zh-cn.php", 'zh-cn');
        $trans = $translator->trans("user.username");

        var_dump($trans);

        $this->assertTrue(true);
    }

}