<?php

namespace hollisho\htranslatorTests\Unit;

use hollisho\htranslator\Locale\LocaleManager;
use hollisho\htranslator\Locale\LocaleVo;
use hollisho\htranslator\MomentTranslator;
use Moment\CustomFormats\MomentJs;
use Moment\MomentException;
use PHPUnit\Framework\TestCase;

class MomentTest extends TestCase
{
    public function test01()
    {
        $m = new \Moment\Moment('now', 'asia/shanghai'); // default is "now" UTC
        $m::setLocale('zh_CN');
        var_dump($m->format('Y-m-d H:i:s'));
        var_dump($m->calendar());
        // 适配moment.js格式
        var_dump($m->format('LLLL', new MomentJs()));
    }

    public function test02()
    {
        // internal function
        $date = date('WS', mktime(12, 22, 0, 5, 27, 2014)); // 22th
        var_dump($date);
        // moment.php
        $m = new \Moment\Moment('2014-05-27T12:22:00', 'CET');
        var_dump($m->format('WS')); // 22nd
    }

    public function test03()
    {
        $momentTranslator = new MomentTranslator();
        $momentTranslator->setDateTime('2022-01-10 10:00:00');
        var_dump($momentTranslator->format('LT'));
        var_dump($momentTranslator->format('LTS'));
        var_dump($momentTranslator->format('L'));
        var_dump($momentTranslator->format('l'));
        var_dump($momentTranslator->format('LL'));
        var_dump($momentTranslator->format('ll'));
        var_dump($momentTranslator->format('LLL'));
        var_dump($momentTranslator->format('lll'));
        var_dump($momentTranslator->format('LLLL'));
        var_dump($momentTranslator->format('llll'));
    }

    /**
     * @throws MomentException
     */
    public function test04()
    {
        $localeManager = new LocaleManager();
        $localeManager->setLocale(LocaleVo::EN_US);
        $momentTranslator = new MomentTranslator($localeManager);
//        $momentTranslator = new MomentTranslator();
        var_dump($momentTranslator->getMoment()->calendar());
    }
}