<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Loaders\ArrayLoader;
use hollisho\htranslator\Loaders\JsonFileLoader;
use hollisho\htranslator\Loaders\PhpFileLoader;
use hollisho\htranslator\Loaders\YamlFileLoader;
use hollisho\htranslator\Resources\FileResource;
use PHPUnit\Framework\TestCase;

/**
 * @author Hollis
 * @desc Loader 内容加载器测试
 * Class LoaderTest
 * @package hollisho\htranslator
 */
class LoaderTest extends TestCase
{
    /**
     * @return void
     * @throws Exceptions\InvalidResourceException
     * @throws Exceptions\NotFoundResourceException
     * @desc 数组测试
     */
    public function testArray()
    {
        $arrayLoader = new ArrayLoader();
        $messageCatalogue = $arrayLoader->load([
            'user' => [
                'username' => 'Hollis'
            ]
        ], 'zh-cn');
        $this->assertTrue($messageCatalogue->all()['messages']['user.username'] == 'Hollis');

    }

    /**
     * @return void
     * @throws Exceptions\InvalidResourceException
     * @throws Exceptions\NotFoundResourceException
     * @desc Yaml文件测试
     */
    public function testYaml()
    {
        $yamlFileLoader = new YamlFileLoader();
        $fileResource = new FileResource(dirname(__DIR__) . "/Files/zh-cn.yaml");
        $messageCatalogue = $yamlFileLoader->load($fileResource, 'zh-cn');
        $this->assertTrue($messageCatalogue->all()['messages']['user.username'] == 'Hollis');
    }

    /**
     * @return void
     * @throws Exceptions\InvalidResourceException
     * @throws Exceptions\NotFoundResourceException
     * @desc json文件测试
     */
    public function testJson()
    {
        $jsonFileLoader = new JsonFileLoader();
        $fileResource = new FileResource(dirname(__DIR__) . "/Files/zh-cn.json");
        $messageCatalogue = $jsonFileLoader->load($fileResource, 'zh-cn');
        $this->assertTrue($messageCatalogue->all()['messages']['user.username'] == 'Hollis');
    }

    /**
     * @return void
     * @throws Exceptions\InvalidResourceException
     * @throws Exceptions\NotFoundResourceException
     * @desc 测试php文件
     */
    public function testPhp()
    {
        $phpFileLoader = new PhpFileLoader();
        $fileResource = new FileResource(dirname(__DIR__) . "/Files/zh-cn.php");
        $messageCatalogue = $phpFileLoader->load($fileResource, 'zh-cn');
        $this->assertTrue($messageCatalogue->all()['messages']['user.username'] == 'Hollis');
    }
}