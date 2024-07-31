<?php

namespace hollisho\htranslatorTests;

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
}