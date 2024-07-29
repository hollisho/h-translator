<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Formatters\MessageFormatter;
use hollisho\htranslator\Loaders\ArrayLoader;
use hollisho\htranslator\Loaders\PhpFileLoader;
use hollisho\htranslator\Resources\ArrayResource;
use hollisho\htranslator\Resources\FileResource;
use PHPUnit\Framework\TestCase;

class MessageFormatterTest extends TestCase
{
    public function testDefault()
    {
        $messageFormatter = new MessageFormatter();
        $format = $messageFormatter->format('Hello World', 'zh-cn', [
            'Hello World' => '世界 您好'
        ]);

        $this->assertTrue($format == '世界 您好');
    }

    /**
     * @throws Exceptions\InvalidResourceException
     * @throws Exceptions\NotFoundResourceException
     */
    public function testMessageCatalogue()
    {
        $arrayResource = new ArrayResource([
            'Hello World' => '世界 您好'
        ]);
        $messageCatalogue = (new ArrayLoader())->load($arrayResource->toArray(), 'zh-cn');
        //追加php配置文件
        $phpFileLoader = new PhpFileLoader();
        $fileResource = new FileResource(dirname(__DIR__) . "/Files/zh-cn.php");
        $messageCatalogue->addCatalogue($phpFileLoader->load($fileResource, 'zh-cn'));
        $messageFormatter = new MessageFormatter($messageCatalogue);
        $format = $messageFormatter->format('Hello World', 'zh-cn');
        $format1 = $messageFormatter->format('user.username', 'zh-cn');

        $this->assertTrue($format == '世界 您好' && $format1 == 'Hollis');
    }
}