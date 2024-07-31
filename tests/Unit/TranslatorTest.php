<?php
namespace hollisho\htranslatorTests;

use hollisho\htranslator\Loaders\PhpFileLoader;
use hollisho\htranslator\Locale\LocaleManager;
use hollisho\htranslator\Resources\ResourceFormatVo;
use hollisho\htranslator\Translator;
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
        $translator->addLoader(ResourceFormatVo::PHP_FILE, $phpFileLoader);
        $translator->addResource(ResourceFormatVo::PHP_FILE, dirname(__DIR__) . "/Files/zh-cn.php", 'zh_CN');
        $this->assertTrue($translator->trans("user.username") == 'Hollis');
    }

    public function testTranslatorMoment()
    {
        $translator = new Translator();

        $phpFileLoader = new PhpFileLoader();
        $translator->addLoader(ResourceFormatVo::PHP_FILE, $phpFileLoader);
        $translator->addResource(ResourceFormatVo::PHP_FILE, dirname(__DIR__) . "/Files/zh-cn.php", 'zh_CN');
        $this->assertIsString($translator->trans("moment"));
    }

}