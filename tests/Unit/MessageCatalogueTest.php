<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Catelogues\MessageCatalogue;
use hollisho\htranslator\Loaders\ArrayLoader;
use hollisho\htranslator\Resources\ArrayResource;
use PHPUnit\Framework\TestCase;

/**
 * @author Hollis
 * @desc 内容目录测试
 * Class MessageCatalogueTest
 * @package hollisho\htranslator
 */
class MessageCatalogueTest extends TestCase
{
    public function test01()
    {
        $messageCatalogue = new MessageCatalogue('zh-cn');
        $messageCatalogue->add([
            'Hello World' => '你好',
            'Make Money' => '赚钱',
        ]);

        $this->assertTrue($messageCatalogue->all()['messages']['Make Money'] == '赚钱');

    }

    /**
     * @throws Exceptions\InvalidResourceException
     * @throws Exceptions\NotFoundResourceException
     */
    public function testArrayResource()
    {
        $arrayResource = new ArrayResource([
            'Hello World' => '世界 你好'
        ]);
        $arrayLoader = new ArrayLoader();
        $messageCatalogue = $arrayLoader->load($arrayResource->toArray(), 'zh-cn');
        $this->assertTrue($messageCatalogue->get('Hello World') == '世界 你好');
    }
}