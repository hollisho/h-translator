<?php
namespace hollisho\htranslatorTests\Unit;

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

    /**
     * @throws BuilderException
     */
    public function testTranslatorMoment()
    {
        $translator = new Translator();

        $phpFileLoader = new PhpFileLoader();
        $translator->addLoader(ResourceFormatVo::PHP_FILE, $phpFileLoader);
        $translator->addResource(ResourceFormatVo::PHP_FILE, dirname(__DIR__) . "/Files/zh-cn.php", 'zh_CN');
        $this->assertIsString($translator->trans("moment"));
    }

    public function testTranslatorConfig()
    {
        $localeManager = new LocaleManager();
        $localeManager->auto_detect = false;
        $localeManager->auto_detect_var = 'lang';
        $localeManager->locale = 'zh_TW';
        $translator = new Translator($localeManager);

        var_dump($translator->getLocale());

    }

}