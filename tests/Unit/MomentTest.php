<?php

namespace hollisho\htranslatorTests;

use hollisho\htranslator\Exceptions\InvalidResourceException;
use hollisho\htranslator\Exceptions\NotFoundResourceException;
use hollisho\htranslator\Locale\LocaleManager;
use hollisho\htranslator\MomentTranslator;
use Moment\CustomFormats\MomentJs;
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
        var_dump($momentTranslator->format());

        var_dump($momentTranslator->trans('llll'));
    }

    /**
     * @throws \Moment\MomentException
     */
    public function test04()
    {
        $localeManager = new LocaleManager();
        $localeManager->setLocale('en_GB');
        $momentTranslator = new MomentTranslator($localeManager);
//        $momentTranslator = new MomentTranslator();
        var_dump($momentTranslator->getMoment()->calendar());
    }
}