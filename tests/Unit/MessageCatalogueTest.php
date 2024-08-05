<?php

namespace hollisho\htranslatorTests\Unit;

use hollisho\htranslator\Catelogues\MessageCatalogue;
use hollisho\htranslator\Exceptions\InvalidResourceException;
use hollisho\htranslator\Exceptions\NotFoundResourceException;
use hollisho\htranslator\Loaders\ArrayLoader;
use hollisho\htranslator\Loaders\MoFileLoader;
use hollisho\htranslator\Loaders\PhpFileLoader;
use hollisho\htranslator\Resources\ArrayResource;
use hollisho\htranslator\Resources\FileResource;
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
     * @return void
     * @throws InvalidResourceException
     * @throws NotFoundResourceException
     * @desc
     */
    public function testArrayResource()
    {
        $arrayResource = new ArrayResource([
            'Hello World' => '世界 你好'
        ]);
        $arrayLoader = new ArrayLoader();
        $messageCatalogue = $arrayLoader->load($arrayResource->__toArray(), 'zh-cn');
        $this->assertTrue($messageCatalogue->get('Hello World') == '世界 你好');
    }

    /**
     * @return void
     * @throws InvalidResourceException
     * @throws NotFoundResourceException
     * @desc
     */
    public function testPhpFileResource()
    {
        $fileResource = new FileResource(dirname(__DIR__) . "/Files/zh-cn.php");
        $phpFileLoader = new PhpFileLoader();
        $messageCatalogue = $phpFileLoader->load($fileResource, 'zh-cn');
        $this->assertTrue($messageCatalogue->get('user.username') == 'Hollis');
    }

    public function testMoFIleResource()
    {
        $fileResource = new FileResource(dirname(__DIR__) . "/Files/zh-cn.mo");
        $moFileLoader = new MoFileLoader();
        $messageCatalogue = $moFileLoader->load($fileResource, 'zh-cn');
        $this->assertTrue($messageCatalogue->get('layout_name') == '布局文件');
    }

    public function testDomain()
    {
        $messageCatalogue = new MessageCatalogue('zh-cn');
        $messageCatalogue->add([
            'date' => date('Y-m-d'),
            'time' => time()
        ], 'datetime');

        $this->assertTrue($messageCatalogue->has('date', 'datetime'));
    }
}