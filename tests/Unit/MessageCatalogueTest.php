<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Catelogues\MessageCatalogue;
use hollisho\htranslator\Loaders\ArrayLoader;
use PHPUnit\Framework\TestCase;

class MessageCatalogueTest extends TestCase
{
    public function test01()
    {
        $messageCatalogue = new MessageCatalogue('zh-cn');
        $messageCatalogue->add([
            'Hello World' => '你好',
            'Make Money' => '赚钱',
        ]);

        var_dump($messageCatalogue);

    }
}